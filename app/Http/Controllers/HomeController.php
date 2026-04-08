<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Product;
use App\Helpers\ServiceEcosystem;
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

        // Get featured products (latest 4 products)
        $featuredProducts = Product::with('store')
            ->latest()
            ->take(4)
            ->get();

        $categories = collect();

        $stages = ServiceEcosystem::getStages();

        return view('home', compact('featuredJobs', 'featuredProducts', 'categories', 'stages'));
    }
}

