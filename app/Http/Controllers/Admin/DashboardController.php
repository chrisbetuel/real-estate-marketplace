<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Location;
use App\Models\Job;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'total_properties' => Property::count(),
            'total_locations' => Location::count(),
            'total_jobs' => Job::count(),
            'total_products' => Product::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'pending_verifications' => User::where('is_verified', false)->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_properties' => Property::with('user')->latest()->take(5)->get(),
        ];

        // Chart data - Users by month (SQLite compatible)
        $usersByMonth = User::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->map(function($item) {
            // Convert month number to integer
            $item->month = (int)$item->month;
            return $item;
        });

        // Chart data - Properties by type
        $propertiesByType = Property::select('property_type', DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();

        return view('admin.dashboard', compact('stats', 'usersByMonth', 'propertiesByType'));
    }
}