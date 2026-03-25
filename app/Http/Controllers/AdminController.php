<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\Dispute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('user_type', 'client')->count(),
            'total_professionals' => User::where('user_type', 'professional')->count(),
            'total_store_owners' => User::where('user_type', 'store_owner')->count(),
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('status', 'open')->count(),
            'total_stores' => Store::count(),
            'verified_stores' => Store::where('is_verified', true)->count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('status', 'released')->sum('platform_fee'),
            'pending_disputes' => Dispute::where('status', 'pending')->count()
        ];

        $recentUsers = User::latest()->take(10)->get();
        $recentJobs = Job::with('client')->latest()->take(10)->get();
        $recentTransactions = Transaction::with(['client', 'professional'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentUsers', 'recentJobs', 'recentTransactions'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('type')) {
            $query->where('user_type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function verifyUser(User $user)
    {
        $user->update(['is_verified' => true]);

        return redirect()->back()->with('success', 'User verified successfully');
    }

    public function suspendUser(User $user)
    {
        $user->update(['is_active' => false]);

        return redirect()->back()->with('success', 'User suspended successfully');
    }

    public function disputes()
    {
        $disputes = Dispute::with(['transaction', 'raisedBy'])
            ->latest()
            ->paginate(20);

        return view('admin.disputes', compact('disputes'));
    }

    public function resolveDispute(Request $request, Dispute $dispute)
    {
        $request->validate([
            'resolution' => 'required|string',
            'action' => 'required|in:refund,release,cancel'
        ]);

        DB::transaction(function() use ($request, $dispute) {
            $dispute->update([
                'status' => 'resolved',
                'resolution' => $request->resolution,
                'resolved_by' => auth()->id(),
                'resolved_at' => now()
            ]);

            switch ($request->action) {
                case 'refund':
                    $dispute->transaction->update(['status' => 'refunded']);
                    // Process refund
                    break;
                case 'release':
                    $dispute->transaction->update(['status' => 'released']);
                    // Release payment
                    break;
                case 'cancel':
                    $dispute->transaction->update(['status' => 'cancelled']);
                    break;
            }
        });

        return redirect()->back()->with('success', 'Dispute resolved successfully');
    }

    public function reports()
    {
        // Generate various reports
        $monthlyRevenue = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('SUM(platform_fee) as total_fees')
        )
        ->where('status', 'released')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->take(12)
        ->get();

        $topProfessionals = User::where('user_type', 'professional')
            ->withCount(['assignedJobs' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum('transactionsAsProfessional', 'professional_amount')
            ->orderBy('assigned_jobs_count', 'desc')
            ->take(10)
            ->get();

        $popularCategories = Job::select(
            'service_category',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('service_category')
        ->orderBy('total', 'desc')
        ->take(10)
        ->get();

        return view('admin.reports', compact(
            'monthlyRevenue', 'topProfessionals', 'popularCategories'
        ));
    }
}