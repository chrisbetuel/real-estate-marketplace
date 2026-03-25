<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Bid;
use App\Models\User;

class ClientDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
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
            'total_bids_received' => Bid::whereIn('project_job_id', $jobs->pluck('id'))->count(),
            'pending_bids' => Bid::whereIn('project_job_id', $jobs->pluck('id'))
                ->where('status', 'pending')
                ->count(),
        ];
        
        // Recent bids received
        $recentBids = Bid::whereIn('project_job_id', $jobs->pluck('id'))
            ->with(['job', 'professional'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('client.dashboard', compact('jobs', 'stats', 'recentBids'));
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
        $job = Job::where('client_id', Auth::id())
            ->with(['bids.professional'])
            ->findOrFail($jobId);
        
        // Get all bids for this job
        $bids = Bid::where('project_job_id', $jobId)
            ->with('professional')
            ->latest()
            ->get();
        
        return view('client.job-bids', compact('job', 'bids'));
    }
    
    public function acceptBid($bidId)
    {
        $bid = Bid::with('job')->findOrFail($bidId);
        
        // Verify the job belongs to this client
        if ($bid->job->client_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Check if job is still open
        if ($bid->job->status != 'open') {
            return redirect()->back()->with('error', 'This job is no longer accepting bids.');
        }
        
        // Accept this bid
        $bid->update(['status' => 'accepted']);
        
        // Reject all other bids for this job
        Bid::where('project_job_id', $bid->job->id)
            ->where('id', '!=', $bidId)
            ->update(['status' => 'rejected']);
        
        // Update job status and assign professional
        $bid->job->update([
            'status' => 'in_progress',
            'assigned_professional_id' => $bid->professional_id
        ]);
        
        return redirect()->route('client.job-bids', $bid->job->id)
            ->with('success', 'Bid accepted! The professional has been notified.');
    }
    
    public function rejectBid($bidId)
    {
        $bid = Bid::with('job')->findOrFail($bidId);
        
        // Verify the job belongs to this client
        if ($bid->job->client_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $bid->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Bid rejected successfully.');
    }
    
    public function completeJob($jobId)
    {
        $job = Job::where('client_id', Auth::id())
            ->where('status', 'in_progress')
            ->findOrFail($jobId);
        
        $job->update(['status' => 'completed']);
        
        return redirect()->route('client.jobs')
            ->with('success', 'Job marked as completed!');
    }
}