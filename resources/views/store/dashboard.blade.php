@extends('layouts.app')

@section('title', 'Store Dashboard - BuildConnect')

@section('content')
<div class="dashboard-wrapper">
    <!-- HAMBURGER MENU BUTTON (Mobile only) -->
    <button class="menu-toggle" id="menuToggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>

    <!-- MOBILE OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="dashboard-layout">
        <!-- SIDEBAR -->
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <div class="sidebar-header">
                <div class="company-badge">
                    <span class="company-initial">{{ substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1) }}</span>
                </div>
                <div class="company-info">
                    <h4>{{ Auth::user()->first_name ?? Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->company_name ?? 'Store Owner' }}</p>
                </div>
                <button class="close-sidebar" id="closeSidebar">×</button>
            </div>
            
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active" data-section="overview">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-5v-7H9v7H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" data-section="products">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    <span>Products</span>
                    @if(($stats['total_products'] ?? 0) > 0)
                        <span class="nav-badge">{{ $stats['total_products'] }}</span>
                    @endif
                </a>
                <a href="#" class="nav-item" data-section="orders">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span>Orders</span>
                </a>
                <a href="#" class="nav-item" data-section="drivers">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M1 3h15v13H1z"/>
                        <circle cx="5" cy="18" r="2"/>
                        <circle cx="16" cy="18" r="2"/>
                    </svg>
                    <span>Delivery Drivers</span>
                </a>
                <a href="#" class="nav-item" data-section="add-product">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    <span>Add Product</span>
                </a>
                <a href="#" class="nav-item" data-section="profile">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Store Profile</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="sidebar-stat">
                    <span>Total Revenue</span>
                    <strong>${{ number_format($stats['total_revenue'] ?? 0) }}</strong>
                </div>
                <div class="sidebar-stat">
                    <span>Total Products</span>
                    <strong>{{ $stats['total_products'] ?? 0 }}</strong>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="dashboard-main">
            <div class="dashboard-container">
                
                <!-- SECTION 1: OVERVIEW DASHBOARD -->
                <div id="section-overview" class="dashboard-section active">
                    <!-- Header -->
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Store Dashboard</h1>
                            <p class="dashboard-subtitle">Manage your store, products, and track sales performance</p>
                        </div>
                        <div class="dashboard-stats">
                            <div class="stat-card">
                                <span class="stat-label">Total Revenue</span>
                                <strong class="stat-number">${{ number_format($stats['total_revenue'] ?? 0) }}</strong>
                            </div>
                            <div class="stat-card">
                                <span class="stat-label">This Month</span>
                                <strong class="stat-number">${{ number_format($stats['monthly_revenue'] ?? 0) }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Store Profile Section -->
                    <div class="store-profile">
                        <div class="store-avatar">
                            @if($store && $store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}">
                            @else
                                <div class="avatar-placeholder">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="8" width="18" height="14" rx="2"/>
                                        <path d="M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="store-info">
                            <div>
                                <h2 class="store-name">{{ $store->name ?? 'Your Store' }}</h2>
                                <p class="store-email">{{ $store->email ?? 'No email set' }}</p>
                            </div>
                            <a href="#" class="store-edit" data-section="profile">
                                Edit Profile
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label-sm">Total Products</span>
                            <strong class="stat-value-lg">{{ $stats['total_products'] ?? 0 }}</strong>
                            <span class="stat-trend up">+{{ $stats['new_products'] ?? 0 }} this month</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label-sm">Active Products</span>
                            <strong class="stat-value-lg">{{ $stats['active_products'] ?? 0 }}</strong>
                            <span class="stat-trend">{{ number_format((($stats['active_products'] ?? 0) / max($stats['total_products'] ?? 1, 1)) * 100) }}% of total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label-sm">Total Sales</span>
                            <strong class="stat-value-lg">{{ $stats['total_sales'] ?? 0 }}</strong>
                            <span class="stat-trend up">+{{ $stats['sales_growth'] ?? 0 }}%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label-sm">Store Views</span>
                            <strong class="stat-value-lg">{{ number_format($stats['total_views'] ?? 0) }}</strong>
                            <span class="stat-trend">this month</span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <a href="#" class="action-btn" data-section="add-product">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Product
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="action-arrow">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                        <a href="#" class="action-btn" data-section="orders">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                            View Orders
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="action-arrow">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                        <a href="#" class="action-btn" data-section="drivers">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M1 3h15v13H1z"/>
                                <circle cx="5" cy="18" r="2"/>
                                <circle cx="16" cy="18" r="2"/>
                            </svg>
                            Delivery Drivers
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="action-arrow">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Products Section (Recent Products) -->
                    <div class="products-section">
                        <div class="section-header">
                            <div>
                                <h3>Your Products</h3>
                                <p>Manage your product inventory and listings</p>
                            </div>
                            <span class="product-count">{{ $products->total() }} total products</span>
                        </div>

                        @if($products->count() > 0)
                            <div class="table-wrapper">
                                <table class="products-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Sales</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products->take(5) as $product)
                                        <tr>
                                            <td data-label="Product">
                                                <div class="product-cell">
                                                    @php
                                                        $images = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);
                                                    @endphp
                                                    @if($images && count($images) > 0)
                                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}" class="product-img">
                                                    @else
                                                        <div class="product-img-placeholder">
                                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                                <path d="M21 15l-5-5L5 21"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="product-details">
                                                        <span class="product-title">{{ $product->name }}</span>
                                                        <span class="product-cat">{{ $product->category }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Price" class="price-cell">${{ number_format($product->price, 2) }}</td>
                                            <td data-label="Stock">
                                                @if(($product->stock ?? 0) <= 5 && ($product->stock ?? 0) > 0)
                                                    <span class="stock-badge low">{{ $product->stock }} left</span>
                                                @elseif(($product->stock ?? 0) <= 0)
                                                    <span class="stock-badge out">Out of stock</span>
                                                @else
                                                    <span class="stock-badge in">{{ $product->stock }} in stock</span>
                                                @endif
                                            </td>
                                            <td data-label="Sales">{{ $product->sales_count ?? 0 }}</td>
                                            <td data-label="Status">
                                                @if($product->is_active ?? true)
                                                    <span class="status-badge active">Active</span>
                                                @else
                                                    <span class="status-badge inactive">Inactive</span>
                                                @endif
                                            </td>
                                            <td data-label="Actions" class="actions-cell">
                                                <a href="#" class="action-link edit-product" data-product-id="{{ $product->id }}" data-section="edit-product">Edit</a>
                                                <form action="{{ route('store-owner.products.delete', $product->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-link delete" onclick="return confirm('Delete this product?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($products->total() > 5)
                                <div class="view-all-link">
                                    <a href="#" class="view-all" data-section="products">View all {{ $products->total() }} products →</a>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                                <h3>No products yet</h3>
                                <p>Start adding products to your store</p>
                                <a href="#" class="empty-btn" data-section="add-product">Add your first product →</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SECTION 2: PRODUCTS (FULL LIST) -->
                <div id="section-products" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">All Products</h1>
                            <p class="dashboard-subtitle">Manage your complete product inventory</p>
                        </div>
                        <a href="#" class="btn-primary" data-section="add-product">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add New Product
                        </a>
                    </div>

                    <div class="table-wrapper">
                        <table class="products-table full">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td data-label="Product">
                                        <div class="product-cell">
                                            @php
                                                $images = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);
                                            @endphp
                                            @if($images && count($images) > 0)
                                                <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}" class="product-img">
                                            @else
                                                <div class="product-img-placeholder">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                                        <path d="M21 15l-5-5L5 21"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="product-details">
                                                <span class="product-title">{{ $product->name }}</span>
                                                <span class="product-cat">{{ $product->category }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Price" class="price-cell">${{ number_format($product->price, 2) }}</td>
                                    <td data-label="Stock">
                                        @if(($product->stock ?? 0) <= 5 && ($product->stock ?? 0) > 0)
                                            <span class="stock-badge low">{{ $product->stock }} left</span>
                                        @elseif(($product->stock ?? 0) <= 0)
                                            <span class="stock-badge out">Out of stock</span>
                                        @else
                                            <span class="stock-badge in">{{ $product->stock }} in stock</span>
                                        @endif
                                    </td>
                                    <td data-label="Sales">{{ $product->sales_count ?? 0 }}</td>
                                    <td data-label="Status">
                                        @if($product->is_active ?? true)
                                            <span class="status-badge active">Active</span>
                                        @else
                                            <span class="status-badge inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td data-label="Actions" class="actions-cell">
                                        <a href="#" class="action-link edit-product" data-product-id="{{ $product->id }}" data-section="edit-product">Edit</a>
                                        <form action="{{ route('store-owner.products.delete', $product->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-link delete" onclick="return confirm('Delete this product?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper">
                        {{ $products->links() }}
                    </div>
                </div>

                <!-- SECTION 3: ORDERS -->
                <div id="section-orders" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Orders</h1>
                            <p class="dashboard-subtitle">Track and manage customer orders</p>
                        </div>
                    </div>
                    <div class="empty-state">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <h3>No orders yet</h3>
                        <p>When customers place orders, they'll appear here</p>
                    </div>
                </div>

                <!-- SECTION 4: DRIVERS -->
                <div id="section-drivers" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Delivery Drivers</h1>
                            <p class="dashboard-subtitle">Manage your delivery team</p>
                        </div>
                        <a href="#" class="btn-primary" data-section="add-driver">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Driver
                        </a>
                    </div>
                    <div class="empty-state">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                            <path d="M1 3h15v13H1z"/>
                            <circle cx="5" cy="18" r="2"/>
                            <circle cx="16" cy="18" r="2"/>
                        </svg>
                        <h3>No drivers yet</h3>
                        <p>Add delivery drivers to manage deliveries</p>
                    </div>
                </div>

                <!-- SECTION 5: ADD PRODUCT -->
                <div id="section-add-product" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Add New Product</h1>
                            <p class="dashboard-subtitle">Create a new product listing</p>
                        </div>
                    </div>
                    <div class="coming-soon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                            <path d="M12 8v4l3 3M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z"/>
                        </svg>
                        <h3>Product Form Coming Soon</h3>
                        <p>You can add products via the Products page using the Add Product button</p>
                        <a href="#" class="btn-primary" data-section="products">Go to Products</a>
                    </div>
                </div>

                <!-- SECTION 6: ADD DRIVER -->
                <div id="section-add-driver" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Add Delivery Driver</h1>
                            <p class="dashboard-subtitle">Add a new driver to your team</p>
                        </div>
                    </div>
                    <div class="coming-soon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                            <path d="M12 8v4l3 3M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z"/>
                        </svg>
                        <h3>Driver Form Coming Soon</h3>
                        <p>You can add drivers via the Drivers page</p>
                        <a href="#" class="btn-primary" data-section="drivers">Go to Drivers</a>
                    </div>
                </div>

                <!-- SECTION 7: EDIT PRODUCT -->
                <div id="section-edit-product" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Edit Product</h1>
                            <p class="dashboard-subtitle">Edit product details</p>
                        </div>
                    </div>
                    <div class="coming-soon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                            <path d="M12 8v4l3 3M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z"/>
                        </svg>
                        <h3>Redirecting...</h3>
                        <p>Taking you to the product edit page</p>
                    </div>
                </div>

                <!-- SECTION 8: STORE PROFILE -->
                <div id="section-profile" class="dashboard-section">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Store Profile</h1>
                            <p class="dashboard-subtitle">Manage your store information</p>
                        </div>
                    </div>
                    <div class="coming-soon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                            <path d="M12 8v4l3 3M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z"/>
                        </svg>
                        <h3>Redirecting...</h3>
                        <p>Taking you to the profile edit page</p>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

@push('styles')
<style>
/* ============================================
   STORE DASHBOARD - FLEX LAYOUT (NO OVERLAY)
   Sidebar and main content in normal flow
============================================ */

.dashboard-wrapper {
    background: #F5F7FA;
    min-height: 100vh;
}

/* Flex Layout - Sidebar + Main Content */
.dashboard-layout {
    display: flex;
    min-height: 100vh;
}

/* Menu Toggle - Mobile Only */
.menu-toggle {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1001;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 10px;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.menu-toggle:hover {
    border-color: #C6A43B;
}

/* Sidebar - Normal Flow (Not Fixed) */
.dashboard-sidebar {
    width: 280px;
    background: #1A2C3E;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    min-height: 100vh;
}

.sidebar-header {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    position: relative;
}

.company-badge {
    width: 48px;
    height: 48px;
    background: #C6A43B;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.company-initial {
    font-size: 20px;
    font-weight: 700;
    color: #1A2C3E;
}

.company-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: #FFFFFF;
    margin: 0;
}

.company-info p {
    font-size: 12px;
    color: #94A3B8;
    margin: 0;
}

.close-sidebar {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #94A3B8;
    display: none;
}

.close-sidebar:hover {
    color: #EF4444;
}

.sidebar-nav {
    flex: 1;
    padding: 16px 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    color: #94A3B8;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
}

.nav-item svg {
    stroke: #94A3B8;
}

.nav-item span {
    flex: 1;
}

.nav-item:hover {
    background: rgba(255,255,255,0.06);
    color: #FFFFFF;
}

.nav-item:hover svg {
    stroke: #C6A43B;
}

.nav-item.active {
    background: rgba(198,164,59,0.12);
    color: #C6A43B;
}

.nav-item.active svg {
    stroke: #C6A43B;
}

.nav-badge {
    background: #334155;
    color: #94A3B8;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.sidebar-stat {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.sidebar-stat:last-child {
    margin-bottom: 0;
}

.sidebar-stat span {
    font-size: 12px;
    color: #94A3B8;
}

.sidebar-stat strong {
    font-size: 14px;
    font-weight: 600;
    color: #C6A43B;
}

/* Mobile Overlay */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    display: none;
}

/* Main Content */
.dashboard-main {
    flex: 1;
    padding: 32px 0;
}

.dashboard-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Desktop: Sidebar always visible */
@media (min-width: 1025px) {
    .menu-toggle {
        display: none;
    }
}

/* Mobile: Sidebar becomes fixed overlay */
@media (max-width: 1024px) {
    .menu-toggle {
        display: flex;
    }
    
    .dashboard-sidebar {
        position: fixed;
        top: 0;
        left: -280px;
        width: 280px;
        height: 100%;
        z-index: 1000;
        transition: left 0.3s ease;
    }
    
    .dashboard-sidebar.open {
        left: 0;
    }
    
    .close-sidebar {
        display: flex;
    }
    
    .dashboard-layout {
        display: block;
    }
    
    .dashboard-main {
        margin-left: 0;
        width: 100%;
    }
}

/* Dashboard Sections */
.dashboard-section {
    display: none;
    animation: fadeIn 0.25s ease;
}

.dashboard-section.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 32px;
    padding-bottom: 20px;
    border-bottom: 1px solid #E2E8F0;
}

.dashboard-title {
    font-size: 28px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 6px 0;
}

.dashboard-subtitle {
    font-size: 14px;
    color: #6B7A8F;
    margin: 0;
}

.dashboard-stats {
    display: flex;
    gap: 24px;
}

.stat-card {
    text-align: right;
}

.stat-label {
    font-size: 11px;
    font-weight: 500;
    color: #8A99B0;
    display: block;
    margin-bottom: 4px;
}

.stat-number {
    font-size: 22px;
    font-weight: 700;
    color: #1A2C3E;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #C6A43B;
    color: #1A2C3E;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #AD8E32;
}

/* Store Profile */
.store-profile {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 32px;
    padding-bottom: 20px;
    border-bottom: 1px solid #E2E8F0;
    flex-wrap: wrap;
}

.store-avatar img,
.avatar-placeholder {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-placeholder {
    background: #F0F2F5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.store-info {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.store-name {
    font-size: 18px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 4px 0;
}

.store-email {
    font-size: 13px;
    color: #8A99B0;
    margin: 0;
}

.store-edit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #C6A43B;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}

.store-edit:hover {
    gap: 12px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.stat-item {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #E2E8F0;
}

.stat-label-sm {
    font-size: 11px;
    font-weight: 500;
    color: #8A99B0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 8px;
}

.stat-value-lg {
    font-size: 28px;
    font-weight: 700;
    color: #1A2C3E;
    display: block;
    margin-bottom: 6px;
}

.stat-trend {
    font-size: 11px;
    color: #8A99B0;
}

.stat-trend.up {
    color: #10B981;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 24px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
    font-size: 13px;
    font-weight: 500;
    color: #1A2C3E;
    text-decoration: none;
    border-bottom: 1px solid #E2E8F0;
    transition: all 0.2s;
    cursor: pointer;
}

.action-btn svg:first-child {
    stroke: #C6A43B;
}

.action-btn:hover {
    color: #C6A43B;
    border-bottom-color: #C6A43B;
    gap: 12px;
}

/* Products Section */
.products-section {
    border-top: 1px solid #E2E8F0;
    padding-top: 32px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.section-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 4px 0;
}

.section-header p {
    font-size: 13px;
    color: #8A99B0;
    margin: 0;
}

.product-count {
    font-size: 13px;
    color: #8A99B0;
    background: white;
    padding: 5px 12px;
    border-radius: 20px;
    border: 1px solid #E2E8F0;
}

.view-all-link {
    text-align: center;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #F0F2F5;
}

.view-all {
    color: #C6A43B;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.view-all:hover {
    text-decoration: underline;
}

/* Tables */
.table-wrapper {
    overflow-x: auto;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
}

.products-table th {
    text-align: left;
    padding: 14px 0;
    font-size: 12px;
    font-weight: 600;
    color: #8A99B0;
    border-bottom: 1px solid #E2E8F0;
}

.products-table td {
    padding: 16px 0;
    border-bottom: 1px solid #F0F2F5;
    vertical-align: middle;
}

.product-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}

.product-img {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
}

.product-img-placeholder {
    width: 48px;
    height: 48px;
    background: #F0F2F5;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-title {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin-bottom: 2px;
}

.product-cat {
    font-size: 11px;
    color: #8A99B0;
}

.price-cell {
    font-weight: 600;
    color: #C6A43B;
}

.stock-badge {
    font-size: 11px;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-block;
}

.stock-badge.in {
    background: #ECFDF5;
    color: #059669;
}

.stock-badge.low {
    background: #FEF3C7;
    color: #D97706;
}

.stock-badge.out {
    background: #FEF2F2;
    color: #DC2626;
}

.status-badge {
    font-size: 11px;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-block;
}

.status-badge.active {
    background: #ECFDF5;
    color: #059669;
}

.status-badge.inactive {
    background: #F0F2F5;
    color: #8A99B0;
}

.actions-cell {
    white-space: nowrap;
}

.action-link {
    font-size: 12px;
    color: #8A99B0;
    text-decoration: none;
    margin-right: 16px;
    transition: color 0.2s;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.action-link:hover {
    color: #C6A43B;
}

.action-link.delete:hover {
    color: #EF4444;
}

.delete-form {
    display: inline;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #F0F2F5;
}

/* Empty State & Coming Soon */
.empty-state, .coming-soon {
    text-align: center;
    padding: 60px 24px;
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.empty-state svg, .coming-soon svg {
    margin-bottom: 16px;
}

.empty-state h3, .coming-soon h3 {
    font-size: 16px;
    font-weight: 500;
    color: #1A2C3E;
    margin: 0 0 6px 0;
}

.empty-state p, .coming-soon p {
    font-size: 13px;
    color: #8A99B0;
    margin-bottom: 20px;
}

.empty-btn {
    display: inline-block;
    padding: 8px 24px;
    background: #C6A43B;
    color: #1A2C3E;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
}

/* Responsive */
@media (max-width: 900px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 20px;
    }
    
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .dashboard-stats {
        width: 100%;
        justify-content: space-between;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .store-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .quick-actions {
        flex-direction: column;
    }
    
    .product-cell {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .actions-cell {
        display: flex;
        gap: 12px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
    const sections = {
        overview: document.getElementById('section-overview'),
        products: document.getElementById('section-products'),
        orders: document.getElementById('section-orders'),
        drivers: document.getElementById('section-drivers'),
        'add-product': document.getElementById('section-add-product'),
        'add-driver': document.getElementById('section-add-driver'),
        'edit-product': document.getElementById('section-edit-product'),
        profile: document.getElementById('section-profile')
    };
    
    // Handle store edit link
    const storeEdit = document.querySelector('.store-edit');
    if (storeEdit) {
        storeEdit.addEventListener('click', function(e) {
            e.preventDefault();
            showSection('profile');
            closeSidebar();
        });
    }
    
    // Handle edit product links
    const editProductLinks = document.querySelectorAll('.edit-product');
    editProductLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            if (productId) {
                // Redirect to edit page
                window.location.href = '/store-owner/products/' + productId + '/edit';
            }
        });
    });
    
    function showSection(sectionId) {
        // Hide all sections
        Object.values(sections).forEach(section => {
            if (section) section.classList.remove('active');
        });
        
        // Show selected section
        if (sections[sectionId]) {
            sections[sectionId].classList.add('active');
        }
        
        // Update active state on nav items
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-section') === sectionId) {
                item.classList.add('active');
            }
        });
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Close sidebar on mobile after navigation
        if (window.innerWidth <= 1024) {
            closeSidebar();
        }
        
        // Handle redirects for specific sections
        if (sectionId === 'profile') {
            setTimeout(function() {
                window.location.href = '{{ route("store-owner.profile.edit") }}';
            }, 1500);
        }
    }
    
    // Add click handlers to nav items
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            if (sectionId) showSection(sectionId);
        });
    });
    
    // Handle quick action buttons
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            if (sectionId) showSection(sectionId);
        });
    });
    
    // Handle view all link
    const viewAllLink = document.querySelector('.view-all');
    if (viewAllLink) {
        viewAllLink.addEventListener('click', function(e) {
            e.preventDefault();
            showSection('products');
        });
    }
    
    // Default to overview
    showSection('overview');
    
    // Sidebar functionality
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('dashboardSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    function openSidebar() {
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', openSidebar);
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
});
</script>
@endpush
@endsection