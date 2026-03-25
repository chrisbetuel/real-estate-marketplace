<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Listing::with('user')->where('status', 'open');

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $listings = $query->latest()->paginate(12);

        return view('listings.index', compact('listings'));
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|gt:budget_min',
            'location' => 'nullable|string',
            'deadline' => 'nullable|date|after:today',
            'experience_level' => 'nullable|string',
        ]);

        $listing = Listing::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'location' => $request->location,
            'deadline' => $request->deadline,
            'experience_level' => $request->experience_level,
            'status' => 'open',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing posted successfully!');
    }

    public function show($id)
    {
        $listing = Listing::with(['user', 'bids.user'])->findOrFail($id);
        
        return view('listings.show', compact('listing'));
    }

    public function edit(Listing $listing)
    {
        if ($listing->user_id != Auth::id()) {
            abort(403);
        }

        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|gt:budget_min',
            'location' => 'nullable|string',
            'status' => 'required|in:open,in_progress,completed,cancelled',
        ]);

        $listing->update($request->all());

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id != Auth::id()) {
            abort(403);
        }

        $listing->delete();

        return redirect()->route('listings.index')
            ->with('success', 'Listing deleted successfully!');
    }
}