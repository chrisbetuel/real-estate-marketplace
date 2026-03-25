<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BidController extends Controller
{
    public function store(Request $request, Job $job)
    {
        try {
            Log::info('Bid submission started');
            
            // Check if user is professional
            if (Auth::user()->user_type != 'professional') {
                return response()->json(['error' => 'Only professionals can submit bids'], 403);
            }
            
            // Validate
            $validated = $request->validate([
                'bid_amount' => 'required|numeric|min:1',
                'timeline' => 'required|integer|min:1',
                'proposal' => 'required|string|min:10',
            ]);
            
            // Check if job is open
            if ($job->status != 'open') {
                return response()->json(['error' => 'This job is no longer accepting bids'], 400);
            }
            
            // Check for existing bid
            $existing = Bid::where('project_job_id', $job->id)
                ->where('professional_id', Auth::id())
                ->first();
                
            if ($existing) {
                return response()->json(['error' => 'You have already submitted a bid for this job'], 400);
            }
            
            // Create bid using the correct column names
            $bid = Bid::create([
                'project_job_id' => $job->id,      // Note: project_job_id, not job_id
                'professional_id' => Auth::id(),
                'amount' => $validated['bid_amount'], // Note: amount, not bid_amount
                'estimated_days' => $validated['timeline'], // Note: estimated_days, not timeline
                'proposal' => $validated['proposal'],
                'status' => 'pending'
            ]);
            
            Log::info('Bid created successfully', ['bid_id' => $bid->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Your bid has been submitted successfully!',
                'bid_id' => $bid->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Bid submission error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to submit bid: ' . $e->getMessage()], 500);
        }
    }
}