<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Bid;
use App\Models\User;
use App\Models\Transaction;
use App\Models\EscrowHold;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class ClientDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client'); // You'll need to create this middleware
    }

    public function index()
    {
        $client = Auth::user();
        
        // Get all jobs posted by this client
        $jobs = Job::where('client_id', $client->id)
            ->with(['assignedProfessional'])
            ->latest()
            ->get();
        
        // Statistics
        $stats = [
            'total_jobs' => $jobs->count(),
            'open_jobs' => $jobs->where('status', 'open')->count(),
            'in_progress_jobs' => $jobs->where('status', 'in_progress')->count(),
            'completed_jobs' => $jobs->where('status', 'completed')->count(),
            'total_bids_received' => Bid::whereIn('job_id', $jobs->pluck('id'))->count(),
            'pending_bids' => Bid::whereIn('job_id', $jobs->pluck('id'))
                ->where('status', 'pending')
                ->count(),
        ];

$unreadCount = \App\Models\Message::whereHas('conversation', function($query) {
            $query->whereHas('participants', function($p) {
                $p->where('user_id', Auth::id());
            });
        })->where('is_read', false)
          ->where('user_id', '!=', Auth::id())
          ->count();
        
        // Recent activity
        $recentBids = Bid::whereIn('job_id', $jobs->pluck('id'))
            ->with(['job', 'professional'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('client.dashboard', compact('jobs', 'stats', 'recentBids', 'unreadCount'));
    }
    
    public function jobs()
    {
        $jobs = Job::where('client_id', Auth::id())
            ->with(['assignedProfessional'])
            ->latest()
            ->paginate(10);
        
        return view('client.jobs', compact('jobs'));
    }
    
    public function jobBids($jobId)
    {
        // Get the job with bids relationship
        $job = Job::where('client_id', Auth::id())
            ->findOrFail($jobId);
        
        // Get all bids for this job using project_job_id
        $bids = Bid::where('project_job_id', $jobId)
            ->with(['professional', 'escrowHold', 'transaction'])
            ->latest()
            ->get();
        
        $hasPaidConnection = auth()->check() && Transaction::where('client_id', Auth::id())
            ->where('project_job_id', $jobId)
            ->where('type', 'connection_fee')
            ->where('status', 'completed')
            ->exists();
         
        \Log::info('Job Bids Debug', [
            'job_id' => $jobId,
            'client_id' => Auth::id(),
            'bids_count' => $bids->count(),
            'bids_data' => $bids->toArray()
        ]);
        
        return view('client.job-bids', compact('job', 'bids', 'hasPaidConnection'));
    }
    
    public function acceptBid($bidId)
    {
        $bid = Bid::with('job')->findOrFail($bidId);
        
        // Verify the job belongs to this client
        if ($bid->job->client_id != Auth::id()) {
            abort(403);
        }
        
        // Check if job is still open
        if ($bid->job->status != 'open') {
            return back()->with('error', 'This job is no longer accepting bids.');
        }
        
        DB::transaction(function () use ($bid, $bidId) {
            // Accept this bid
            $bid->update(['status' => 'accepted']);
            
            // Reject all other bids for this job
            Bid::where('project_job_id', $bid->project_job_id)
                ->where('id', '!=', $bidId)
                ->update(['status' => 'rejected']);
            
            // Update job status and assign professional
            $bid->job->update([
                'status' => 'in_progress',
                'assigned_professional_id' => $bid->professional_id
            ]);

            // Create escrow for the bid amount
            $amount = $bid->amount;
            $wallet = Auth::user()->wallet;

            if (!($wallet && $wallet->balance >= $amount)) {
                throw new \Exception('Insufficient wallet balance. Please add funds or use external payment.');
            }

            // Wallet payment
            $wallet->deductBalance($amount, 'Escrow for job ' . $bid->job->title);

            $transaction = Transaction::create([
                'client_id' => Auth::id(),
                'professional_id' => $bid->professional_id,
                'project_job_id' => $bid->project_job_id,
                'amount' => $amount,
                'platform_fee' => $amount * 0.10,
                'professional_amount' => $amount * 0.90,
                'status' => 'held',
                'payment_method' => 'wallet',
                'description' => 'Job escrow: ' . $bid->job->title,
                'held_until' => now()->addDays(14),
            ]);

                $escrow = EscrowHold::create([
                    'job_id' => $bid->project_job_id,
                'client_id' => Auth::id(),
                'professional_id' => $bid->professional_id,
                'amount' => $amount,
                'platform_fee' => $amount * 0.10,
                'status' => 'pending',
            ]);

            $bid->update([
                'transaction_id' => $transaction->id,
                'escrow_id' => $escrow->id,
            ]);
        });

        return redirect()->route('client.job-bids', $bid->job->id)
            ->with('success', 'Bid accepted and escrow created! Job payment held securely.');
    }
    
    public function rejectBid($bidId)
    {
        $bid = Bid::findOrFail($bidId);
        
        // Verify the job belongs to this client
        if ($bid->job->client_id != Auth::id()) {
            abort(403);
        }
        
        $bid->update(['status' => 'rejected']);
        
        return back()->with('success', 'Bid rejected successfully.');
    }
    
    public function completeJob($jobId)
    {
        $job = Job::where('client_id', Auth::id())
            ->where('status', 'in_progress')
            ->findOrFail($jobId);
        
        DB::transaction(function () use ($job) {
            if ($job->escrowHold) {
                $job->escrowHold->release();
            }
            $job->update(['status' => 'completed']);
        });
        
        return redirect()->route('client.jobs')
            ->with('success', 'Job completed! Professional has been paid.');
    }
}
