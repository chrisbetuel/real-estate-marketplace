<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobRecommendedController extends Controller
{
    public function index(Request $request)
    {
        // Simple, deterministic "recommended" set for public browsing.
        // If you later want personalization, extend this query using auth/user/session.
        $jobs = Job::query()
            ->where('status', 'open')
            ->with('client')
            ->latest()
            ->paginate(12)
            ->appends($request->query());

        return view('jobs.recommended', compact('jobs'));
    }
}

