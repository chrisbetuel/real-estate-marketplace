<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfessionalProfile;
use App\Models\Job;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['professionalProfile'])
            ->where('user_type', 'professional');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $professionals = $query->latest()->paginate(15);

        return view('professionals.index', compact('professionals'));
    }

    public function show(User $professional)
    {
        $professional->load(['professionalProfile']);
        return view('professionals.show', compact('professional'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'professional') {
            return redirect()->route('dashboard')
                ->with('error', 'Access denied. This area is for professionals only.');
        }

$user->load(['professionalProfile']);
        $profile = $user->professionalProfile;
        
        $stats = [
            'total_jobs' => $user->assignedJobs()->count(),
            'active_jobs' => $user->assignedJobs()->where('status', 'in_progress')->count(),
            'total_bids' => $user->bids()->count(),
'completed_jobs' => $user->completed_jobs_count,
'avg_rating' => round($user->rating, 1),
        ];

        $recentJobs = $user->assignedJobs()->latest()->take(5)->get();
$recentBids = collect([]); // Disabled - no projectJob relation

        return view('professionals.dashboard', compact('user', 'profile', 'stats', 'recentJobs', 'recentBids'));
    }
}

