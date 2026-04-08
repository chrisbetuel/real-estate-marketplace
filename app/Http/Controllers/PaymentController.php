<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Job;
use App\Models\Product;
use App\Models\EscrowHold;
use App\Models\Wallet;
use App\Models\Cart;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function showEscrowJob(Bid $bid)
    {
        if ($bid->transaction || $bid->escrowHold) {
            return redirect()->route('client.job-bids', $bid->project_job_id)
                ->with('success', 'Escrow already paid.');
        }

        return view('payment.escrow-job', compact('bid'));
    }

    /*
    |--------------------------------------------------------------------------
    | ESCROW PAYMENT (JOB / PRODUCT)
    |--------------------------------------------------------------------------
    */

    public function initialize(Request $request)
    {
        $request->validate([
            'job_id' => 'required_without:product_id|exists:jobs,id',
            'product_id' => 'required_without:job_id|exists:products,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $reference = 'TXN_' . Str::random(20);

        if ($request->job_id) {
            $job = Job::findOrFail($request->job_id);
            $professionalId = $job->assigned_professional_id;
        } else {
            $product = Product::findOrFail($request->product_id);
            $professionalId = $product->store->user_id;
        }

        $transaction = Transaction::create([
            'project_job_id' => $request->job_id,
            'product_id' => $request->product_id,
            'client_id' => Auth::id(),
            'professional_id' => $professionalId,
            'amount' => $request->amount,
            'platform_fee' => $request->amount * 0.10,
            'professional_amount' => $request->amount * 0.90,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'transaction_reference' => $reference,
            'held_until' => now()->addDays(14)
        ]);

        return response()->json([
            'transaction' => $transaction,
            'authorization_url' => $this->initializePaymentGateway($transaction)
        ]);
    }

    public function verify($reference)
    {
        $transaction = Transaction::where('transaction_reference', $reference)->firstOrFail();

        if ($this->verifyPaymentGateway($reference)) {
            $transaction->update([
                'status' => 'held',
                'payment_details' => ['verified_at' => now()]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful. Funds held in escrow.',
                'transaction' => $transaction
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function release(Transaction $transaction)
    {
        if ($transaction->client_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($transaction->status !== 'held') {
            return response()->json(['error' => 'Invalid transaction'], 400);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => 'released',
                'released_at' => now()
            ]);

            $this->releasePaymentToProfessional($transaction);

            if ($transaction->project_job_id) {
                $transaction->projectJob->update(['status' => 'completed']);
            }
        });

        return response()->json(['success' => true]);
    }

    public function dispute(Transaction $transaction)
    {
        $transaction->update(['status' => 'disputed']);

        return response()->json(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | PROFESSIONAL UNLOCK PAYMENT
    |--------------------------------------------------------------------------
    */

    public function showProfessionalUnlock(\App\Models\User $professional)
    {
        if (! $professional->isProfessional()) {
            abort(404);
        }

        $unlockFee = 10;

        $hasPaid = Auth::check() && Transaction::where('client_id', Auth::id())
            ->where('professional_id', $professional->id)
            ->where('type', 'connection_fee')
            ->where('status', 'completed')
            ->exists();

        if ($hasPaid) {
            return redirect()->route('professionals.show', $professional)
                ->with('info', "You have already unlocked this professional's details.");
        }

        return view('payment.professional-unlock', compact('professional', 'unlockFee'));
    }

    public function processProfessionalUnlock(Request $request, \App\Models\User $professional)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,stripe',
            'stripe_token' => 'required_if:payment_method,stripe',
        ]);

        if (! $professional->isProfessional()) {
            abort(404);
        }

        $fee = 10;

        DB::transaction(function () use ($request, $professional, $fee) {
            if ($request->payment_method === 'wallet') {
                $wallet = Auth::user()->wallet;
                if (!$wallet || $wallet->balance < $fee) {
                    throw new \Exception('Insufficient wallet balance');
                }
                $wallet->deductBalance($fee, 'Professional unlock fee - ' . $professional->name);
            } else {
                Charge::create([
                    'amount' => $fee * 100,
                    'currency' => 'usd',
                    'source' => $request->stripe_token,
                ]);
            }

            Transaction::create([
                'client_id' => Auth::id(),
                'professional_id' => $professional->id,
                'type' => 'connection_fee',
                'amount' => $fee,
                'platform_fee' => $fee * 0.10,
                'professional_amount' => $fee * 0.90,
                'status' => 'completed',
                'description' => 'Professional unlock fee - ' . $professional->name,
            ]);

            session(['unlocked_professional_' . $professional->id => true]);
        });

        return redirect()->route('professionals.show', $professional)
            ->with('success', 'Payment successful! Full professional details unlocked.');
    }

    /*
    |--------------------------------------------------------------------------
    | CONNECTION PAYMENT (PAY TO CONNECT)
    |--------------------------------------------------------------------------
    */

    public function processConnectionPayment(Request $request, Job $job)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,stripe',
            'stripe_token' => 'required_if:payment_method,stripe',
        ]);

        $fee = 25;
        $professionalId = $job->assigned_professional_id ?? null;

        DB::transaction(function () use ($request, $job, $fee, $professionalId) {
            if ($request->payment_method === 'wallet') {
                $wallet = Auth::user()->wallet;
                if (!$wallet || $wallet->balance < $fee) {
                    throw new \Exception('Insufficient wallet balance');
                }
                $wallet->deductBalance($fee, 'Connection fee for job ' . $job->title);
            } else {
                Charge::create([
                    'amount' => $fee * 100,
                    'currency' => 'usd',
                    'source' => $request->stripe_token,
                ]);
            }

            Transaction::create([
                'client_id' => Auth::id(),
                'professional_id' => $professionalId,
                'project_job_id' => $job->id,
                'type' => 'connection_fee',
                'amount' => $fee,
                'platform_fee' => $fee * 0.10,
                'professional_amount' => $fee * 0.90,
                'status' => 'completed',
                'description' => 'Connection fee - Job: ' . $job->title,
            ]);

            session(['connected_job_' . $job->id => true]);
        });

        return redirect()->back()->with('success', 'Connection payment successful! You can now contact the professional.');
    }


    /*
    |--------------------------------------------------------------------------
    | WALLET SYSTEM
    |--------------------------------------------------------------------------
    */

    public function addFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'stripe_token' => 'required',
        ]);

        Charge::create([
            'amount' => $request->amount * 100,
            'currency' => 'usd',
            'source' => $request->stripe_token,
        ]);

        $wallet = Auth::user()->wallet ?? Wallet::create(['user_id' => Auth::id()]);
        $wallet->addBalance($request->amount, "Deposit");

        return back()->with('success', 'Funds added');
    }

    /*
    |--------------------------------------------------------------------------
    | ESCROW (WALLET BASED)
    |--------------------------------------------------------------------------
    */

    public function createEscrow(Request $request, Job $job)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);

        $wallet = Auth::user()->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance');
        }

        $wallet->deductBalance($request->amount);

        EscrowHold::create([
            'job_id' => $job->id,
            'client_id' => Auth::id(),
            'professional_id' => $job->assigned_professional_id,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Escrow created');
    }

    /*
    |--------------------------------------------------------------------------
    | CART & CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function addToCart($productId)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        $cart->increment('quantity');

        return back()->with('success', 'Added to cart');
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $wallet = Auth::user()->wallet;

        if (!$wallet || $wallet->balance < $total) {
            return back()->with('error', 'Insufficient balance');
        }

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'paid'
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $wallet->deductBalance($total);
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Order placed');
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT GATEWAY (MOCK)
    |--------------------------------------------------------------------------
    */

    private function initializePaymentGateway($transaction)
    {
        return "https://payment.com/pay/" . $transaction->transaction_reference;
    }

    private function verifyPaymentGateway($reference)
    {
        return true;
    }

    private function releasePaymentToProfessional($transaction)
    {
        // implement payout
    }
}