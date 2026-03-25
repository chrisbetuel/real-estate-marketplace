<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Job;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function initialize(Request $request)
    {
        $request->validate([
            'job_id' => 'required_without:product_id|exists:jobs,id',
            'product_id' => 'required_without:job_id|exists:products,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $reference = 'TXN_' . Str::random(20);

        if ($request->has('job_id')) {
            $job = Job::findOrFail($request->job_id);
            $professionalId = $job->assigned_professional_id;
        } else {
            $product = Product::findOrFail($request->product_id);
            $professionalId = $product->store->user_id;
        }

        $transaction = Transaction::create([
            'job_id' => $request->job_id,
            'product_id' => $request->product_id,
            'client_id' => Auth::id(),
            'professional_id' => $professionalId,
            'amount' => $request->amount,
            'platform_fee' => $request->amount * 0.10, // 10% platform fee
            'professional_amount' => $request->amount * 0.90,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'transaction_reference' => $reference,
            'held_until' => now()->addDays(14) // Hold for 14 days
        ]);

        // Initialize payment with gateway (example with Paystack)
        // This is where you'd integrate with your chosen payment gateway

        return response()->json([
            'transaction' => $transaction,
            'authorization_url' => $this->initializePaymentGateway($transaction)
        ]);
    }

    public function verify(Request $request, $reference)
    {
        $transaction = Transaction::where('transaction_reference', $reference)->firstOrFail();

        // Verify payment with gateway
        $paymentVerified = $this->verifyPaymentGateway($reference);

        if ($paymentVerified) {
            $transaction->update([
                'status' => 'held',
                'payment_details' => ['verified_at' => now()]
            ]);

            // Notify professional that payment is in escrow
            // event(new PaymentHeld($transaction));

            return response()->json([
                'success' => true,
                'message' => 'Payment successful. Funds held in escrow.',
                'transaction' => $transaction
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment verification failed'
        ], 400);
    }

    public function release(Transaction $transaction)
    {
        // Check if user is authorized (client only)
        if ($transaction->client_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if transaction is in held status
        if ($transaction->status !== 'held') {
            return response()->json(['error' => 'Transaction cannot be released'], 400);
        }

        DB::transaction(function() use ($transaction) {
            // Update transaction status
            $transaction->update([
                'status' => 'released',
                'released_at' => now()
            ]);

            // Process payment to professional (via gateway)
            $this->releasePaymentToProfessional($transaction);

            // Update job status
            if ($transaction->job_id) {
                $transaction->job->update(['status' => 'completed']);
            }
        });

        // Notify professional
        // event(new PaymentReleased($transaction));

        return response()->json([
            'success' => true,
            'message' => 'Payment released to professional'
        ]);
    }

    public function dispute(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'disputed'
        ]);

        // Notify admin
        // event(new PaymentDisputed($transaction));

        return response()->json([
            'success' => true,
            'message' => 'Dispute raised. Admin will review.'
        ]);
    }

    private function initializePaymentGateway($transaction)
    {
        // Implementation depends on payment gateway
        // Return authorization URL
        return "https://payment-gateway.com/pay/" . $transaction->transaction_reference;
    }

    private function verifyPaymentGateway($reference)
    {
        // Implement verification logic
        return true;
    }

    private function releasePaymentToProfessional($transaction)
    {
        // Implement payment release logic
    }
}