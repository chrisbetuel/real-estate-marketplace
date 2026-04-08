<?php
// app/Http/Middleware/CheckConnectionPayment.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Transaction;
use App\Models\EscrowHold;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class CheckConnectionPayment
{
    public function handle(Request $request, Closure $next)
    {
        $jobId = $request->route('job') ?? $request->route('listing');
        $job = Job::find($jobId);
        
        if (!$job) {
            return $next($request);
        }
        
        // Check if user is the client trying to message their own job
        if (Auth::id() == $job->client_id) {
            return $next($request);
        }
        
        // Check comprehensive payment/connection status
        $hasPaid = session('connected_job_' . $jobId) ||
            Transaction::where('client_id', Auth::id())
                ->where('project_job_id', $jobId)
                ->where('type', 'connection_fee')
                ->where('status', 'completed')
                ->exists() ||
            EscrowHold::where('job_id', $jobId)
                ->where('client_id', Auth::id())
                ->exists() ||
            Conversation::where('job_id', $jobId)
                ->whereHas('participants', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->exists();

        if (!$hasPaid) {
            return redirect()->route('payment.connection', $job)
                ->with('error', 'Pay connection fee to contact professional.');
        }
        
        return $next($request);
    }
}