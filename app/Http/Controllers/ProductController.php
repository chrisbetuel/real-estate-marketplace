<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('store')->where('is_available', true);

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('type', $request->category);
        }

        if ($request->filled('location')) {
            $query->whereHas('store', function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                  ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        $products = $query->latest()->paginate(12);
        
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('stores.create')
                ->with('error', 'Please register a store first');
        }

        return view('products.create', compact('store'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:sale,rent,both',
            'price_sale' => 'required_if:type,sale,both|nullable|numeric|min:0',
            'price_rent' => 'required_if:type,rent,both|nullable|numeric|min:0',
            'rent_period' => 'required_if:type,rent,both|nullable|in:daily,weekly,monthly',
            'quantity' => 'required|integer|min:1',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        // Handle specifications
        $specifications = [];
        if ($request->has('specifications.key') && $request->has('specifications.value')) {
            $keys = $request->input('specifications.key');
            $values = $request->input('specifications.value');
            
            for ($i = 0; $i < count($keys); $i++) {
                if (!empty($keys[$i]) && !empty($values[$i])) {
                    $specifications[$keys[$i]] = $values[$i];
                }
            }
        }

        $product = Product::create([
            'store_id' => Auth::user()->store->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'type' => $request->type,
            'price_sale' => $request->price_sale,
            'price_rent' => $request->price_rent,
            'rent_period' => $request->rent_period,
            'quantity' => $request->quantity,
            'specifications' => $specifications,
            'images' => $images,
            'is_available' => true
        ]);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product listed successfully!');
    }

    public function show(Product $product)
    {
        $product->load('store');
        
        $relatedProducts = Product::where('store_id', $product->store_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function viewingRequest(Request $request, Product $product)
    {
        $request->validate([
            'preferred_date' => 'required|date|after:today',
            'message' => 'required|string'
        ]);

        // Here you would typically create a viewing request notification
        // For now, we'll just redirect with a success message
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Viewing request sent to store owner!');
    }
}