<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Bid;

class ProfessionalDashboardController extends Controller
{
    public function index()
    {
        $professional = Auth::user();
        
        // Get all bids submitted by this professional
        $bids = Bid::where('professional_id', $professional->id)
            ->with(['job', 'job.client'])
            ->latest()
            ->get();
        
        // Statistics
        $stats = [
            'total_bids' => $bids->count(),
            'pending_bids' => $bids->where('status', 'pending')->count(),
            'accepted_bids' => $bids->where('status', 'accepted')->count(),
            'rejected_bids' => $bids->where('status', 'rejected')->count(),
            'total_earnings' => $bids->where('status', 'accepted')->sum('amount'),
            'active_jobs' => Job::where('assigned_professional_id', $professional->id)
                ->where('status', 'in_progress')
                ->count(),
            'completed_jobs' => Job::where('assigned_professional_id', $professional->id)
                ->where('status', 'completed')
                ->count(),
        ];
        
        // Recommended jobs
        $recommendedJobs = Job::where('status', 'open')
            ->where('client_id', '!=', $professional->id)
            ->with('client')
            ->latest()
            ->take(5)
            ->get();
        
        return view('professional.dashboard', compact('bids', 'stats', 'recommendedJobs'));
    }
    
    public function bids()
    {
        $bids = Bid::where('professional_id', Auth::id())
            ->with(['job', 'job.client'])
            ->latest()
            ->paginate(10);
        
        return view('professional.bids', compact('bids'));
    }
    
    public function editBid($id)
    {
        $bid = Bid::where('professional_id', Auth::id())
            ->where('status', 'pending')
            ->with('job')
            ->findOrFail($id);
        
        return view('professional.edit-bid', compact('bid'));
    }
    
    public function updateBid(Request $request, $id)
    {
        $bid = Bid::where('professional_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $request->validate([
            'bid_amount' => 'required|numeric|min:1',
            'timeline' => 'required|integer|min:1',
            'proposal' => 'required|string|min:10',
        ]);
        
        $bid->update([
            'amount' => $request->bid_amount,
            'estimated_days' => $request->timeline,
            'proposal' => $request->proposal,
        ]);
        
        return redirect()->route('professional.bids')
            ->with('success', 'Bid updated successfully!');
    }
    
    public function withdrawBid($id)
    {
        $bid = Bid::where('professional_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $bid->delete();
        
        return redirect()->route('professional.bids')
            ->with('success', 'Bid withdrawn successfully!');
    }
}