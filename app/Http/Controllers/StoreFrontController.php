<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreFrontController extends Controller
{
    /**
     * Display all stores
     */
    public function stores()
    {
        $stores = Store::where('is_active', true)
            ->withCount('products')
            ->latest()
            ->paginate(12);
        
        return view('store-front.stores', compact('stores'));
    }

    /**
     * Display a specific store with its products
     */
    public function store($id)
    {
        // Get store with products - only show active products with stock
        $store = Store::with(['products' => function($query) {
            $query->where('is_active', true)
                  ->where('stock', '>', 0)
                  ->latest();
        }])->findOrFail($id);
        
        // Debug logging
        Log::info('Store Detail View', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'products_count' => $store->products->count(),
            'products' => $store->products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'is_active' => $product->is_active,
                    'stock' => $product->stock,
                    'price' => $product->price
                ];
            })->toArray()
        ]);
        
        return view('store-front.store-detail', compact('store'));
    }

    /**
     * Display all products (storefront)
     */
    public function products(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with('store')
            ->where('stock', '>', 0);
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Product::distinct()->pluck('category');
        
        return view('store-front.products', compact('products', 'categories'));
    }

    /**
     * Display a specific product
     */
    public function product($id)
    {
        $product = Product::with('store')
            ->where('is_active', true)
            ->findOrFail($id);
        
        // Increment view count
        $product->increment('views_count');
        
        // Related products
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();
        
        return view('store-front.product-detail', compact('product', 'relatedProducts'));
    }

    /**
     * Add product to cart with quantity
     */
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Please login to add items to cart.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add items to cart.');
        }
        
        $product = Product::findOrFail($productId);
        
        if (!$product->is_active) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Product is not available.'], 400);
            }
            return redirect()->back()->with('error', 'Product is not available.');
        }
        
        if ($product->stock <= 0) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Product is out of stock.'], 400);
            }
            return redirect()->back()->with('error', 'Product is out of stock.');
        }
        
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > $product->stock) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Requested quantity exceeds available stock.'], 400);
            }
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }
        
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
        
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Total quantity would exceed available stock.'], 400);
                }
                return redirect()->back()->with('error', 'Total quantity would exceed available stock.');
            }
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
        
        // Get updated cart count
        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $cartCount,
                'cart_total' => $this->getCartTotal()
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * View cart with real-time calculations
     */
    public function cart()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        $cartData = $this->calculateCartTotals($cartItems);
        
        return view('store-front.cart', $cartData);
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request, $cartItemId)
    {
        $cartItem = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->findOrFail($cartItemId);
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        // Get updated cart data
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $cartData = $this->calculateCartTotals($cartItems);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'item_total' => number_format($cartItem->product->price * $cartItem->quantity, 2),
                'subtotal' => number_format($cartData['subtotal'], 2),
                'tax' => number_format($cartData['tax'], 2),
                'total' => number_format($cartData['total'], 2),
                'cart_count' => $cartData['cart_count']
            ]);
        }
        
        return redirect()->route('shop.cart')
            ->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($cartItemId)
    {
        $cartItem = CartItem::where('user_id', Auth::id())
            ->findOrFail($cartItemId);
        
        $cartItem->delete();
        
        if (request()->ajax()) {
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
            $cartData = $this->calculateCartTotals($cartItems);
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => $cartData['cart_count'],
                'subtotal' => number_format($cartData['subtotal'], 2),
                'tax' => number_format($cartData['tax'], 2),
                'total' => number_format($cartData['total'], 2)
            ]);
        }
        
        return redirect()->route('shop.cart')
            ->with('success', 'Item removed from cart!');
    }

    /**
     * Get cart count (for AJAX)
     */
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        
        $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    /**
     * Calculate cart totals
     */
    private function calculateCartTotals($cartItems)
    {
        $items = [];
        $subtotal = 0;
        $cart_count = 0;
        
        foreach ($cartItems as $item) {
            $item_total = $item->product->price * $item->quantity;
            $subtotal += $item_total;
            $cart_count += $item->quantity;
            
            $items[] = [
                'id' => $item->id,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total' => $item_total
            ];
        }
        
        $tax = $subtotal * 0.07; // 7% tax
        $total = $subtotal + $tax;
        
        return [
            'cartItems' => $cartItems,
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'cart_count' => $cart_count
        ];
    }

    /**
     * Get cart total
     */
    private function getCartTotal()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        return $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.products')
                ->with('error', 'Your cart is empty.');
        }
        
        $cartData = $this->calculateCartTotals($cartItems);
        
        // Check wallet balance
        $wallet = Auth::user()->wallet;
        $walletBalance = $wallet ? $wallet->balance : 0;
        
        return view('store-front.checkout', array_merge($cartData, [
            'walletBalance' => $walletBalance,
            'user' => Auth::user()
        ]));
    }

    /**
     * Process order
     */
    public function processOrder(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.products')
                ->with('error', 'Your cart is empty.');
        }
        
        $cartData = $this->calculateCartTotals($cartItems);
        
        // Validate wallet balance
        $wallet = Auth::user()->wallet;
        if (!$wallet || $wallet->balance < $cartData['total']) {
            return redirect()->route('shop.checkout')
                ->with('error', 'Insufficient balance. Please add funds to your wallet.');
        }
        
        DB::beginTransaction();
        
        try {
            // Create order
            // Determine store_id from first cart item (assume same store)
            $storeId = $cartItems->first()->product->store_id;
            
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'store_id' => $storeId,
                'subtotal' => $cartData['subtotal'],
                'tax' => $cartData['tax'],
                'total' => $cartData['total'],
                'status' => \App\Models\OrderStatus::PENDING,
                'payment_method' => 'wallet',
                'payment_status' => 'escrow_held',
                'shipping_address' => json_encode([
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'phone' => $request->phone,
                ]),
            ]);
            
            // Create order items (no stock update yet)
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
            
            // Create escrow hold and deduct wallet
            $escrow = \App\Models\EscrowHold::createForOrder($order);
            $wallet->deductBalance($cartData['total'], "Escrow hold for Order #{$order->order_number}");
            $order->update(['status' => \App\Models\OrderStatus::ESCROW_HELD]);
            
            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();
            
            DB::commit();
            
            return redirect()->route('shop.order-confirmation', $order)
                ->with('success', 'Order placed and funds held in escrow! Confirm receipt after delivery.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order processing error: ' . $e->getMessage());
            return redirect()->route('shop.checkout')
                ->with('error', 'Order processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Order confirmation
     */
    public function orderConfirmation($orderId)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);
        
        return view('store-front.order-confirmation', compact('order'));
    }

    /**
     * My orders
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);
        
        return view('store-front.my-orders', compact('orders'));
    }

    /**
     * Order details
     */
    public function orderDetails(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load(['items.product', 'store', 'escrowHold']);
        
        return view('store-front.order-details', compact('order'));
    }

    /**
     * Buyer confirms receipt of order, releases escrow
     */
    public function confirmReceipt(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($order->status !== \App\Models\OrderStatus::ESCROW_HELD) {
            return back()->with('error', 'Cannot confirm this order status.');
        }
        
        if (!$order->escrowHold) {
            return back()->with('error', 'No escrow hold found.');
        }
        
        DB::transaction(function () use ($order) {
            $order->escrowHold->release();
            $order->update(['status' => \App\Models\OrderStatus::RELEASED]);
        });
        
        return redirect()->route('shop.my-orders')
            ->with('success', 'Receipt confirmed! Payment released to seller.');
    }
}
