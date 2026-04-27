<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StoreDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('store_owner');
    }

    /**
     * Display store dashboard
     */
    public function index()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('store-owner.profile.edit')
                ->with('info', 'Please complete your store profile first.');
        }
        
        $products = Product::where('store_id', $store->id)
            ->latest()
            ->paginate(10);
        
        $stats = [
            'total_products' => $products->total(),
            'active_products' => Product::where('store_id', $store->id)
                ->where('is_active', true)
                ->count(),
            'total_sales' => Product::where('store_id', $store->id)
                ->sum('sales_count'),
            'total_views' => Product::where('store_id', $store->id)
                ->sum('views_count'),
        ];
        
        return view('store.dashboard', compact('store', 'products', 'stats'));
    }

    /**
     * Show store profile edit form
     */
    public function editProfile()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            $store = new Store();
            $store->owner_id = Auth::id();
        }
        
        return view('store.profile', compact('store'));
    }

    /**
     * Update store profile
     */
    public function updateProfile(Request $request)
    {
        $store = Auth::user()->store;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if (!$store) {
            $store = Store::create([
                'owner_id' => Auth::id(),
                'name' => $validated['name'],
                'description' => $validated['description'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'is_active' => true,
            ]);
        } else {
            $store->update($validated);
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }
            
            $path = $request->file('logo')->store('stores/logos', 'public');
            $store->update(['logo' => $path]);
        }
        
        return redirect()->route('store-owner.dashboard')
            ->with('success', 'Store profile updated successfully!');
    }

    /**
     * Show product list
     */
    public function products()
    {
        $store = Auth::user()->store;
        $products = Product::where('store_id', $store->id)
            ->latest()
            ->paginate(10);
        
        return view('store.products', compact('products'));
    }

    /**
     * Show create product form
     */
    public function createProduct()
    {
        return view('store.products-create');
    }

    /**
     * Store a new product
     */
    public function storeProduct(Request $request)
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->back()->with('error', 'Please complete your store profile first.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }
        
        try {
            DB::transaction(function () use ($store, $validated, $images) {
                Product::create([
                    'store_id' => $store->id,
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'price_sale' => $validated['price'],
                    'quantity' => $validated['stock'],
                    'type' => 'sale',
                    'category' => $validated['category'],
                    'images' => json_encode($images),
                    'is_active' => true,
                ]);
            });
            
            return redirect()->route('store-owner.products')
                ->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create product. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Show edit product form
     */
    public function editProduct($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        
        return view('store.products-edit', compact('product'));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, $id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        // Handle new images
        if ($request->hasFile('images')) {
            $images = json_decode($product->images, true) ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
            $validated['images'] = json_encode($images);
        }
        
        $product->update($validated);
        
        // FIXED: Use correct route name
        return redirect()->route('store-owner.products')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product
     */
    public function deleteProduct($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        
        // Delete images
        $images = json_decode($product->images, true) ?? [];
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $product->delete();
        
        return redirect()->route('store-owner.products')
            ->with('success', 'Product deleted successfully!');
    }

    public function myOrders()
    {
        $store = Auth::user()->store;
        $orders = Order::where('store_id', $store->id)
            ->with(['items.product', 'user', 'escrowHold'])
            ->latest()
            ->paginate(15);
        
        return view('store.my-orders', compact('orders'));
    }

    public function releaseOrder(Order $order)
    {
        $store = Auth::user()->store;
        
        if ($order->store_id !== $store->id) {
            abort(403);
        }
        
        if (!$order->escrowHold) {
            return back()->with('error', 'No escrow hold found for this order.');
        }
        
        DB::transaction(function () use ($order) {
            $order->escrowHold->release();
            $order->update(['status' => \App\Models\OrderStatus::RELEASED]);
        });
        
        return back()->with('success', 'Payment released to your wallet and stock updated!');
    }
}
