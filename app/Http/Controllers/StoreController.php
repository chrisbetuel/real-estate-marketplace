<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::where('is_verified', true)
            ->where('is_active', true);

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('store_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        if ($request->filled('location')) {
            $query->where(function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                  ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        $stores = $query->withCount('products')->paginate(12);

        return view('store.index', compact('stores'));
    }

    public function myStore()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('stores.create')
                ->with('info', 'Please register your store first');
        }

        $products = $store->products()->paginate(12);

        return view('store.show', compact('store', 'products'));
    }

    public function create()
    {
        if (!Auth::user()->isStoreOwner()) {
            return redirect()->route('home')
                ->with('error', 'Only store owners can register stores');
        }

        return view('store.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'store_phone' => 'required|string|max:20',
            'store_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'nullable|string',
            'specialization' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'business_hours' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->store_name,
            'description' => $request->description,
            'email' => $request->store_email,
            'phone' => $request->store_phone,
            'address' => $request->store_address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'specialization' => $request->specialization,
            'business_hours' => $request->business_hours,
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('store-logos', 'public');
            $data['logo'] = $path;
        }

        $data['owner_id'] = Auth::id();
        
        $store = Store::create($data);

        return redirect()->route('stores.show', $store)
            ->with('success', 'Store registered successfully! Pending verification.');
    }

    public function show(Store $store)
    {
        $products = $store->products()
            ->where('is_available', true)
            ->latest()
            ->paginate(12);

        return view('store.show', compact('store', 'products'));
    }

    public function edit(Store $store)
    {
        if ($store->owner_id !== Auth::id()) {
            abort(403);
        }

        return view('store.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        if ($store->owner_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'store_phone' => 'required|string|max:20',
            'store_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'images.*' => 'image|max:2048',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo', 'images']);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('store-logos', 'public');
            $data['logo'] = $path;
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('store-images', 'public');
            }
            $data['images'] = array_merge(($store->images ?? []), $imagePaths);
        }

        $store->update($data);

        return redirect()->route('stores.show', $store)
            ->with('success', 'Store updated successfully');
    }

    public function dashboard()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('stores.create')
                ->with('info', 'Please register your store first');
        }

        $recentProducts = $store->products()
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_products' => $store->products()->count(),
            'active_products' => $store->products()->where('is_available', true)->count(),
        ];

        return view('store.dashboard', compact('store', 'stats', 'recentProducts'));
    }

    public function products(Store $store)
    {
        $products = $store->products()
            ->latest()
            ->paginate(12);

        return view('store.products', compact('store', 'products'));
    }
}

