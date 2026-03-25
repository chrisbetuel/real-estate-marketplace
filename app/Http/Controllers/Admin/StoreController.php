<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with(['owner', 'products' => function($q) {
            $q->latest()->limit(3);
        }])->withCount('products');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $stores = $query->latest()->paginate(15);

        return view('admin.stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        $store->load(['owner', 'products']);
        return view('admin.stores.show', compact('store'));
    }

    public function toggleVerification(Store $store)
    {
        $store->is_verified = !$store->is_verified;
        $store->save();

        return back()->with('success', 'Store verification status updated.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return back()->with('success', 'Store deleted successfully.');
    }
}

