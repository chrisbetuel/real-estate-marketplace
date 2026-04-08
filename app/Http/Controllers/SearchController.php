<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProfessionalProfile;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function jobs(Request $request)
    {
        $query = Property::query();

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where(function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                  ->orWhere('state', 'like', '%' . $request->location . '%')
                  ->orWhere('address', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('property_type', $request->category);
        }

        $properties = $query->where('status', 'available')->paginate(12);

        return view('search.jobs', compact('properties'));
    }

    public function professionals(Request $request)
    {
        $query = \App\Models\User::with(['professionalProfile'])
            ->where('user_type', 'professional');

        if ($request->filled('keyword') || $request->filled('search')) {
            $searchTerm = $request->filled('keyword') ? $request->keyword : $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('professionalProfile', function($q2) use ($searchTerm) {
                      $q2->where('profession', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('professionalProfile', function($q) use ($request) {
                $q->where('profession', $request->category);
            });
        }

        if ($request->filled('location')) {
            $query->whereHas('professionalProfile', function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('city', 'like', '%' . $request->location . '%')
                      ->orWhere('state', 'like', '%' . $request->location . '%');
                });
            });
        }

        $professionals = $query->latest()->paginate(15);

        return view('professional.index', compact('professionals'));
    }

    public function products(Request $request)
    {
        $query = Product::with('store');

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->where('is_active', true)->paginate(12);

        return view('search.products', compact('products'));
    }

    public function stores(Request $request)
    {
        $query = Store::query();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        $stores = $query->where('is_active', true)->paginate(12);

        return view('search.stores', compact('stores'));
    }
}

