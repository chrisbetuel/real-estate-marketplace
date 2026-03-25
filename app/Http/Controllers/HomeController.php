<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured jobs (latest 3 open jobs)
        $featuredJobs = Job::with('client')
            ->where('status', 'open')
            ->latest()
            ->take(3)
            ->get();

        // Get featured products (latest 4 available products)
        $featuredProducts = Product::with('store')
            ->where('is_available', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredJobs', 'featuredProducts'));
    }
}