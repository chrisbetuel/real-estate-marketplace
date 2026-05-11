<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PosExpense;
use App\Models\PosSale;
use App\Models\PosSaleItem;
use App\Models\PosShop;
use App\Models\PosInventory;
use App\Models\PosStockTransfer;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ================================================
       SINGLE SHOP
       ================================================ */

    public function singleShop()
    {
        $todaySales = PosSale::where('user_id', Auth::id())
            ->whereDate('sale_date', today())
            ->where('status', 'completed')
            ->get();

        $todayExpenses = PosExpense::where('user_id', Auth::id())
            ->whereDate('expense_date', today())
            ->get();

        $stats = [
            'today_sales_count' => $todaySales->count(),
            'today_revenue' => $todaySales->sum('total_amount'),
            'today_items' => PosSaleItem::whereIn('pos_sale_id', $todaySales->pluck('id'))->sum('quantity'),
            'today_expenses_count' => $todayExpenses->count(),
            'today_expenses_total' => $todayExpenses->sum('amount'),
            'today_net' => $todaySales->sum('total_amount') - $todayExpenses->sum('amount'),
        ];

        $recentSales = PosSale::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('pos.single-shop', compact('stats', 'recentSales'));
    }

    public function sale()
    {
        $products = Product::where('is_active', true)
            ->where('type', 'sale')
            ->where('price_sale', '>', 0)
            ->select('id', 'name', 'price_sale', 'quantity as stock')
            ->get();

        return view('pos.sale', compact('products'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:cash,card,mobile_money',
            'amount_paid' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $subtotal = 0;
        $taxRate = 0.18;

        foreach ($validated['items'] as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
        }

        $taxAmount = $subtotal * $taxRate;
        $totalAmount = $subtotal + $taxAmount;
        $changeDue = $validated['amount_paid'] - $totalAmount;

        if ($changeDue < 0) {
            return response()->json(['error' => 'Amount paid is less than total.'], 422);
        }

        try {
            DB::beginTransaction();

            $sale = PosSale::create([
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'amount_paid' => $validated['amount_paid'],
                'change_due' => $changeDue,
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
            ]);

            foreach ($validated['items'] as $item) {
                $itemTax = ($item['price'] * $item['quantity']) * $taxRate;
                PosSaleItem::create([
                    'pos_sale_id' => $sale->id,
                    'product_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'tax_rate' => $taxRate * 100,
                    'tax_amount' => $itemTax,
                    'total_price' => ($item['price'] * $item['quantity']) + $itemTax,
                ]);

                if (!empty($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->decrement('quantity', $item['quantity']);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $sale->sale_number,
                'redirect' => route('pos.receipt', $sale),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Checkout failed: ' . $e->getMessage()], 500);
        }
    }

    public function receipt(PosSale $sale)
    {
        if ($sale->user_id !== Auth::id()) {
            abort(403);
        }

        $sale->load('items');
        return view('pos.receipt', compact('sale'));
    }

    public function dailyReport(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        $sales = PosSale::where('user_id', Auth::id())
            ->whereDate('sale_date', $date)
            ->where('status', 'completed')
            ->with('items')
            ->get();

        $expenses = PosExpense::where('user_id', Auth::id())
            ->whereDate('expense_date', $date)
            ->get();

        $totalRevenue = $sales->sum('total_amount');
        $totalExpenses = $expenses->sum('amount');

        $report = [
            'date' => $date,
            'total_sales' => $sales->count(),
            'total_revenue' => $totalRevenue,
            'total_subtotal' => $sales->sum('subtotal'),
            'total_tax' => $sales->sum('tax_amount'),
            'total_discount' => $sales->sum('discount_amount'),
            'total_items_sold' => PosSaleItem::whereIn('pos_sale_id', $sales->pluck('id'))->sum('quantity'),
            'payment_breakdown' => $sales->groupBy('payment_method')->map->count(),
            'sales' => $sales,
            'total_expenses' => $totalExpenses,
            'expenses_count' => $expenses->count(),
            'expense_breakdown' => $expenses->groupBy('category')->map->sum('amount'),
            'expenses' => $expenses,
            'net_profit' => $totalRevenue - $totalExpenses,
        ];

        return view('pos.daily-report', compact('report'));
    }

    public function history()
    {
        $sales = PosSale::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(20);

        return view('pos.history', compact('sales'));
    }

    public function quickAddProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_sale' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();

        $store = $user->store;
        if (!$store) {
            $store = Store::create([
                'owner_id' => $user->id,
                'name' => $user->name . ' Store',
                'email' => $user->email,
                'is_active' => true,
            ]);
        }

        $product = Product::create([
            'store_id' => $store->id,
            'name' => $validated['name'],
            'price_sale' => $validated['price_sale'],
            'quantity' => $validated['quantity'],
            'type' => 'sale',
            'category' => $validated['category'] ?? 'General',
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price_sale' => $product->price_sale,
                'stock' => $product->quantity,
            ],
        ]);
    }

    /* ================================================
       EXPENSES
       ================================================ */

    public function expenses(Request $request)
    {
        $query = PosExpense::where('user_id', Auth::id());

        if ($request->filled('from')) {
            $query->whereDate('expense_date', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('expense_date', '<=', $request->input('to'));
        }
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $expenses = $query->latest('expense_date')->paginate(20);
        $totalAmount = (clone $query)->sum('amount');

        $categories = PosExpense::where('user_id', Auth::id())
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('pos.expenses.index', compact('expenses', 'totalAmount', 'categories'));
    }

    public function createExpense()
    {
        return view('pos.expenses.create');
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,card,mobile_money',
            'receipt_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        PosExpense::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['expense_date'],
            'payment_method' => $validated['payment_method'],
            'receipt_number' => $validated['receipt_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('pos.expenses')
            ->with('success', 'Expense recorded successfully.');
    }

    public function editExpense(PosExpense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pos.expenses.edit', compact('expense'));
    }

    public function updateExpense(Request $request, PosExpense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,card,mobile_money',
            'receipt_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('pos.expenses')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroyExpense(PosExpense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('pos.expenses')
            ->with('success', 'Expense deleted successfully.');
    }

    /* ================================================
       MULTI SHOP
       ================================================ */

    public function multiShop()
    {
        $user = Auth::user();

        $shopIds = $user->posShops()->pluck('id')
            ->merge($user->managedPosShops()->pluck('pos_shops.id'))
            ->unique();

        $shops = PosShop::whereIn('id', $shopIds)
            ->withCount(['sales', 'staff'])
            ->get();

        $allSales = PosSale::whereIn('pos_shop_id', $shopIds)
            ->where('status', 'completed');

        $todaySales = (clone $allSales)->whereDate('sale_date', today())->get();

        $stats = [
            'total_shops' => $shops->count(),
            'total_revenue' => $allSales->sum('total_amount'),
            'today_revenue' => $todaySales->sum('total_amount'),
            'today_sales_count' => $todaySales->count(),
            'total_items_sold' => PosSaleItem::whereIn('pos_sale_id', $allSales->pluck('id'))->sum('quantity'),
        ];

        $bestShop = $shops->sortByDesc(fn($s) => $s->sales()->where('status','completed')->sum('total_amount'))->first();

        $lowStockAlerts = PosInventory::whereIn('pos_shop_id', $shopIds)
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->where('quantity', '>', 0)
            ->with(['shop', 'product'])
            ->take(10)
            ->get();

        $recentSales = PosSale::whereIn('pos_shop_id', $shopIds)
            ->with(['posShop', 'items'])
            ->latest()
            ->take(10)
            ->get();

        return view('pos.multi-shop', compact('shops', 'stats', 'bestShop', 'lowStockAlerts', 'recentSales'));
    }

    public function shops()
    {
        $user = Auth::user();
        $ownedShops = $user->posShops()->latest()->get();
        $managedShops = $user->managedPosShops()->latest()->get();
        $shops = $ownedShops->merge($managedShops)->unique('id');
        return view('pos.shops.index', compact('shops'));
    }

    public function createShop()
    {
        return view('pos.shops.create');
    }

    public function storeShop(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $shop = PosShop::create([
            'owner_id' => Auth::id(),
            'name' => $validated['name'],
            'location' => $validated['location'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('pos.shops.dashboard', $shop)
            ->with('success', 'Shop "' . $shop->name . '" created successfully!');
    }

    public function shopDashboard(PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $todaySales = $shop->sales()
            ->where('status', 'completed')
            ->whereDate('sale_date', today())
            ->get();

        $weekSales = $shop->sales()
            ->where('status', 'completed')
            ->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        $stats = [
            'today_revenue' => $todaySales->sum('total_amount'),
            'today_sales_count' => $todaySales->count(),
            'today_items' => PosSaleItem::whereIn('pos_sale_id', $todaySales->pluck('id'))->sum('quantity'),
            'week_revenue' => $weekSales->sum('total_amount'),
            'total_revenue' => $shop->total_revenue,
            'total_sales' => $shop->sales()->where('status', 'completed')->count(),
            'staff_count' => $shop->staff()->count(),
            'low_stock' => $shop->low_stock_count,
            'out_of_stock' => $shop->out_of_stock_count,
        ];

        $recentSales = $shop->sales()
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        $inventories = $shop->inventories()
            ->with('product')
            ->latest()
            ->take(10)
            ->get();

        $staff = $shop->staff;

        return view('pos.shops.dashboard', compact('shop', 'stats', 'recentSales', 'inventories', 'staff'));
    }

    public function shopSale(PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $role = Auth::user()->posShopRole($shop);
        if (!in_array($role, ['admin', 'manager', 'cashier'])) {
            abort(403, 'You do not have permission to make sales in this shop.');
        }

        $inventories = $shop->inventories()
            ->where('quantity', '>', 0)
            ->with('product')
            ->get();

        $products = $inventories->map(function ($inv) {
            return [
                'id' => $inv->product->id,
                'name' => $inv->product->name,
                'price_sale' => $inv->product->price_sale,
                'stock' => $inv->quantity,
            ];
        });

        return view('pos.shops.sale', compact('shop', 'products'));
    }

    public function shopCheckout(Request $request, PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:cash,card,mobile_money,mpesa,airtel_money,halopesa',
            'amount_paid' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $subtotal = 0;
        $taxRate = 0.18;

        foreach ($validated['items'] as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
        }

        $taxAmount = $subtotal * $taxRate;
        $totalAmount = $subtotal + $taxAmount;
        $changeDue = $validated['amount_paid'] - $totalAmount;

        if ($changeDue < 0) {
            return response()->json(['error' => 'Amount paid is less than total.'], 422);
        }

        try {
            DB::beginTransaction();

            $sale = PosSale::create([
                'user_id' => Auth::id(),
                'pos_shop_id' => $shop->id,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'amount_paid' => $validated['amount_paid'],
                'change_due' => $changeDue,
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
            ]);

            foreach ($validated['items'] as $item) {
                $itemTax = ($item['price'] * $item['quantity']) * $taxRate;
                PosSaleItem::create([
                    'pos_sale_id' => $sale->id,
                    'product_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'tax_rate' => $taxRate * 100,
                    'tax_amount' => $itemTax,
                    'total_price' => ($item['price'] * $item['quantity']) + $itemTax,
                ]);

                $inventory = PosInventory::where('pos_shop_id', $shop->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($inventory) {
                    if ($inventory->quantity < $item['quantity']) {
                        DB::rollBack();
                        return response()->json(['error' => 'Not enough stock for ' . $item['name']], 422);
                    }
                    $inventory->decrement('quantity', $item['quantity']);
                }

                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $sale->sale_number,
                'redirect' => route('pos.receipt', $sale),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Checkout failed: ' . $e->getMessage()], 500);
        }
    }

    public function transferStock()
    {
        $user = Auth::user();

        $shopIds = $user->posShops()->pluck('id')
            ->merge($user->managedPosShops()->pluck('pos_shops.id'))
            ->unique();

        $shops = PosShop::whereIn('id', $shopIds)->where('is_active', true)->get();
        $products = Product::where('is_active', true)->where('type', 'sale')->select('id', 'name')->get();

        return view('pos.shops.transfer', compact('shops', 'products'));
    }

    public function storeTransfer(Request $request)
    {
        $validated = $request->validate([
            'from_shop_id' => 'required|exists:pos_shops,id',
            'to_shop_id' => 'required|exists:pos_shops,id|different:from_shop_id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $fromShop = PosShop::findOrFail($validated['from_shop_id']);
        $this->authorizeShopAccess($fromShop);

        $inventory = PosInventory::where('pos_shop_id', $validated['from_shop_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if (!$inventory || $inventory->quantity < $validated['quantity']) {
            return redirect()->back()->with('error', 'Insufficient stock in source shop for this transfer.');
        }

        try {
            DB::beginTransaction();

            $inventory->decrement('quantity', $validated['quantity']);

            $toInventory = PosInventory::firstOrCreate(
                [
                    'pos_shop_id' => $validated['to_shop_id'],
                    'product_id' => $validated['product_id'],
                ],
                ['quantity' => 0, 'low_stock_threshold' => 10]
            );
            $toInventory->increment('quantity', $validated['quantity']);

            PosStockTransfer::create([
                'from_shop_id' => $validated['from_shop_id'],
                'to_shop_id' => $validated['to_shop_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
                'created_by' => Auth::id(),
                'completed_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('pos.multi-shop')
                ->with('success', 'Stock transferred successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transfer failed: ' . $e->getMessage());
        }
    }

    public function shopReports(PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $period = request('period', 'today');
        $startDate = match($period) {
            'today' => today(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => today(),
        };
        $endDate = now();

        $sales = $shop->sales()
            ->where('status', 'completed')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->with('items')
            ->get();

        $report = [
            'period' => $period,
            'total_sales' => $sales->count(),
            'total_revenue' => $sales->sum('total_amount'),
            'total_subtotal' => $sales->sum('subtotal'),
            'total_tax' => $sales->sum('tax_amount'),
            'total_items_sold' => PosSaleItem::whereIn('pos_sale_id', $sales->pluck('id'))->sum('quantity'),
            'payment_breakdown' => $sales->groupBy('payment_method')->map->count(),
            'avg_sale_value' => $sales->count() > 0 ? $sales->avg('total_amount') : 0,
            'sales_by_day' => $sales->groupBy(fn($s) => $s->sale_date->format('Y-m-d'))->map->count(),
            'top_products' => PosSaleItem::whereIn('pos_sale_id', $sales->pluck('id'))
                ->selectRaw('product_name, SUM(quantity) as total_qty, SUM(total_price) as total_revenue')
                ->groupBy('product_name')
                ->orderByDesc('total_qty')
                ->take(10)
                ->get(),
        ];

        return view('pos.shops.reports', compact('shop', 'report'));
    }

    public function shopStaff(PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $staff = $shop->staff;
        $role = Auth::user()->posShopRole($shop);

        return view('pos.shops.staff', compact('shop', 'staff', 'role'));
    }

    public function storeStaff(Request $request, PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $role = Auth::user()->posShopRole($shop);
        if (!in_array($role, ['admin', 'manager'])) {
            return redirect()->back()->with('error', 'Only admins and managers can add staff.');
        }

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|string|in:manager,cashier',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user->id === $shop->owner_id) {
            return redirect()->back()->with('error', 'User is already the shop owner.');
        }

        if ($shop->staff()->where('users.id', $user->id)->exists()) {
            $shop->staff()->updateExistingPivot($user->id, [
                'role' => $validated['role'],
                'is_active' => true,
            ]);
            return redirect()->back()->with('success', 'Staff role updated.');
        }

        $shop->staff()->attach($user->id, [
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Staff added successfully.');
    }

    public function removeStaff(Request $request, PosShop $shop, User $user)
    {
        $this->authorizeShopAccess($shop);

        $role = Auth::user()->posShopRole($shop);
        if (!in_array($role, ['admin', 'manager'])) {
            return redirect()->back()->with('error', 'Only admins and managers can remove staff.');
        }

        $shop->staff()->detach($user->id);

        return redirect()->back()->with('success', 'Staff removed successfully.');
    }

    public function quickAddProductToShop(Request $request, PosShop $shop)
    {
        $this->authorizeShopAccess($shop);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_sale' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            $store = Store::create([
                'owner_id' => $user->id,
                'name' => $user->name . ' Store',
                'email' => $user->email,
                'is_active' => true,
            ]);
        }

        $product = Product::create([
            'store_id' => $store->id,
            'name' => $validated['name'],
            'price_sale' => $validated['price_sale'],
            'quantity' => $validated['quantity'],
            'type' => 'sale',
            'category' => $validated['category'] ?? 'General',
            'is_active' => true,
        ]);

        PosInventory::create([
            'pos_shop_id' => $shop->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'low_stock_threshold' => 10,
        ]);

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price_sale' => $product->price_sale,
                'stock' => $validated['quantity'],
            ],
        ]);
    }

    private function authorizeShopAccess(PosShop $shop): void
    {
        if (!Auth::user()->canAccessPosShop($shop)) {
            abort(403, 'You do not have access to this shop.');
        }
    }
}

