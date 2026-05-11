<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SavedJobsController extends Controller
{
    public function index(Request $request)
    {
        // There is no saved-jobs pivot/model in this repo; the existing feature is Job Alerts.
        // For now, map /saved-jobs to the same public "recommended" jobs list.
        // Later: connect this to a real saved_jobs relationship.
        $jobs = Job::query()
            ->where('status', 'open')
            ->with('client')
            ->latest()
            ->paginate(12)
            ->appends($request->query());

        return view('jobs.recommended', compact('jobs'));
    }
}

