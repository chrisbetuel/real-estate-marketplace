<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of jobs
     */
    public function index(Request $request)
    {
        $query = Job::with('client')->where('status', 'open');

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('service_category', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $jobs = $query->latest()->paginate(12);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Display the specified job
     */
    public function show(Job $job)
    {
        // Load relationships
        $job->load(['client', 'bids.bidder']);

        $userBid = Auth::check() && Auth::user()->user_type == 'professional' 
            ? $job->bids()->where('professional_id', Auth::id())->first() 
            : null;

        return view('jobs.show', compact('job', 'userBid'));
    }

    /**
     * Show the form for creating a new job
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created job
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category' => 'required|string',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|gt:budget_min',
            'location' => 'nullable|string',
            'deadline' => 'nullable|date|after:today',
            'required_skills' => 'nullable|array',
        ]);

        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'service_category' => $request->service_category,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'location' => $request->location,
            'deadline' => $request->deadline,
            'required_skills' => json_encode($request->required_skills),
            'status' => 'open',
            'client_id' => Auth::id(),
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job posted successfully!');
    }
}