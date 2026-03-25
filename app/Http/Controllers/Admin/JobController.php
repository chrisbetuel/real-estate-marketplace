<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function show($id)
    {
        $job = Job::with(['client', 'bids.user'])->findOrFail($id);
        return view('admin.jobs.show', compact('job'));
    }

    public function index(Request $request)
    {
        $query = Job::with('client');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->latest()->paginate(15);
        
        return view('admin.jobs.index', compact('jobs'));
    }
}