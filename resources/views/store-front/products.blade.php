@extends('layouts.app')

@section('title', 'Products - BuildConnect')

@section('content')
<div class="dashboard-wrapper">
    <!-- HAMBURGER MENU BUTTON -->
    <button class="menu-toggle" id="menuToggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>

    <!-- OVERLAY SIDEBAR -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-header">
            <div class="company-badge">
                <span class="company-initial">{{ substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="company-info">
                <h4>{{ Auth::user()->first_name ?? Auth::user()->name }}</h4>
                <p>{{ Auth::user()->company_name ?? 'Contractor' }}</p>
            </div>
            <button class="close-sidebar" id="closeSidebar">×</button>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-5v-7H9v7H5a2 2 0 0 1-2-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('client.jobs') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                <span>My Jobs</span>
            </a>
            <a href="{{ route('shop.products') }}" class="nav-item active">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                <span>Products</span>
            </a>
            <a href="{{ route('shop.stores') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Stores</span>
            </a>
            <a href="{{ route('shop.cart') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span>Cart</span>
            </a>
            <a href="{{ route('messages.index') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span>Messages</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="sidebar-stat">
                <span>Total Products</span>
                <strong>{{ $products->total() }}</strong>
            </div>
            <div class="sidebar-stat">
                <span>Categories</span>
                <strong>{{ $categories->count() }}</strong>
            </div>
        </div>
    </aside>

    <!-- OVERLAY BACKGROUND -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN CONTENT -->
    <main class="dashboard-main">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-text">
                    <h1>Browse <span style="color: gold;">Products</span></h1>
                    <p>Discover quality construction materials, tools, and equipment from our trusted partner stores.</p>
                </div>
                <div class="welcome-actions">
                    <a href="{{ route('shop.stores') }}" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        Browse Stores
                    </a>
                    <a href="{{ route('shop.cart') }}" class="btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        My Cart
                    </a>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-content">
                        <span class="stat-label">Total Products</span>
                        <span class="stat-value">{{ $products->total() }}</span>
                    </div>
                    <div class="stat-icon total">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <span class="stat-label">Categories</span>
                        <span class="stat-value">{{ $categories->count() }}</span>
                    </div>
                    <div class="stat-icon open">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <span class="stat-label">Featured</span>
                        <span class="stat-value">{{ $products->getCollection()->where('is_featured', true)->count() }}</span>
                    </div>
                    <div class="stat-icon bids">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <span class="stat-label">Avg Price</span>
                        <span class="stat-value">${{ number_format($products->getCollection()->avg('price') ?? 0, 0) }}</span>
                    </div>
                    <div class="stat-icon completed">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Category Quick Actions -->
            @if($categories->count() > 0)
            <div class="quick-actions">
                <a href="{{ route('shop.products') }}" class="quick-card {{ !request('category') ? 'active' : '' }}">
                    <div class="quick-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                    </div>
                    <div>
                        <h4>All Products</h4>
                        <p>Browse everything</p>
                    </div>
                </a>
                @foreach($categories->take(3) as $cat)
                <a href="{{ route('shop.products', array_merge(request()->except('page'), ['category' => $cat])) }}"
                   class="quick-card {{ request('category') == $cat ? 'active' : '' }}">
                    <div class="quick-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <div>
                        <h4>{{ $cat }}</h4>
                        <p>Filter by category</p>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            <!-- Main Content Grid -->
            <div class="content-grid">
                <!-- Filters Sidebar -->
                <div class="filters-card">
                    <div class="filters-header">
                        <h3>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                            </svg>
                            Filters
                        </h3>
                    </div>
                    <div class="filters-body">
                        <form method="GET" action="{{ route('shop.products') }}" id="filterForm">
                            <!-- Search -->
                            <div class="filter-group">
                                <label class="filter-label">Search</label>
                                <div class="search-input-wrap">
                                    <input type="text" name="search" class="filter-search"
                                           value="{{ request('search') }}" placeholder="Search products...">
                                    @if(request('search'))
                                        <a href="{{ route('shop.products', request()->except(['search', 'page'])) }}" class="search-clear">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="filter-group">
                                <label class="filter-label">Category</label>
                                <div class="filter-options">
                                    <label class="filter-option {{ !request('category') ? 'active' : '' }}">
                                        <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                                        <span>All Categories</span>
                                    </label>
                                    @foreach($categories as $cat)
                                        <label class="filter-option {{ request('category') == $cat ? 'active' : '' }}">
                                            <input type="radio" name="category" value="{{ $cat }}" {{ request('category') == $cat ? 'checked' : '' }} onchange="this.form.submit()">
                                            <span>{{ $cat }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Product Type -->
                            <div class="filter-group">
                                <label class="filter-label">Product Type</label>
                                <div class="filter-options">
                                    <label class="filter-option {{ !request('type') ? 'active' : '' }}">
                                        <input type="radio" name="type" value="" {{ !request('type') ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                        <span>All</span>
                                    </label>
                                    <label class="filter-option {{ request('type') == 'sale' ? 'active' : '' }}">
                                        <input type="radio" name="type" value="sale" {{ request('type') == 'sale' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                        <span>For Sale</span>
                                    </label>
                                    <label class="filter-option {{ request('type') == 'rent' ? 'active' : '' }}">
                                        <input type="radio" name="type" value="rent" {{ request('type') == 'rent' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                        <span>For Rent</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="filter-group">
                                <label class="filter-label">Price Range</label>
                                <div class="price-range">
                                    <div class="price-inputs">
                                        <div class="price-input-wrap">
                                            <span class="price-currency">$</span>
                                            <input type="number" name="min_price" class="price-input"
                                                   value="{{ request('min_price') }}" placeholder="Min"
                                                   onchange="document.getElementById('filterForm').submit()">
                                        </div>
                                        <span class="price-separator">—</span>
                                        <div class="price-input-wrap">
                                            <span class="price-currency">$</span>
                                            <input type="number" name="max_price" class="price-input"
                                                   value="{{ request('max_price') }}" placeholder="Max"
                                                   onchange="document.getElementById('filterForm').submit()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Filters Summary -->
                            @if(request()->anyFilled(['search', 'category', 'type', 'min_price', 'max_price']))
                            <div class="active-filters-box">
                                <span class="af-title">Active Filters</span>
                                <div class="af-chips">
                                    @if(request('search'))
                                        <span class="af-chip">
                                            "{{ request('search') }}"
                                            <a href="{{ route('shop.products', request()->except(['search', 'page'])) }}">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                                </svg>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('category'))
                                        <span class="af-chip">
                                            {{ request('category') }}
                                            <a href="{{ route('shop.products', request()->except(['category', 'page'])) }}">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                                </svg>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('type'))
                                        <span class="af-chip">
                                            {{ request('type') == 'sale' ? 'For Sale' : 'For Rent' }}
                                            <a href="{{ route('shop.products', request()->except(['type', 'page'])) }}">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                                </svg>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('min_price') || request('max_price'))
                                        <span class="af-chip">
                                            ${{ request('min_price') ?: '0' }} - ${{ request('max_price') ?: '∞' }}
                                            <a href="{{ route('shop.products', request()->except(['min_price', 'max_price', 'page'])) }}">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                                </svg>
                                            </a>
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('shop.products') }}" class="af-clear">Clear all</a>
                            </div>
                            @endif

                            <div class="filter-actions">
                                <button type="submit" class="btn-filter-apply">Apply Filters</button>
                                @if(request()->anyFilled(['search', 'category', 'type', 'min_price', 'max_price']))
                                    <a href="{{ route('shop.products') }}" class="btn-filter-clear">Clear Filters</a>
                                @endif
                            </div>

                            @foreach(request()->except(['search', 'category', 'type', 'min_price', 'max_price', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="products-section">
                    <div class="section-header">
                        <div>
                            <h3>Products</h3>
                            <p>{{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }} available</p>
                        </div>
                        <form method="GET" action="{{ route('shop.products') }}" class="sort-form" id="sortForm">
                            @foreach(request()->except(['sort', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="sort-select-wrapper">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="products-grid">
                        @forelse($products as $product)
                            <div class="product-card">
                                <div class="product-image-wrap">
                                    <a href="{{ route('shop.product', $product->id) }}">
                                        <img src="{{ $product->first_image ?? '' }}"
                                             alt="{{ $product->name }}"
                                             class="product-image"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="product-image-placeholder" style="display: none;">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="M21 15l-5-5L5 21"/>
                                            </svg>
                                        </div>
                                    </a>

                                    <div class="product-badges">
                                        @if($product->is_featured)
                                            <span class="badge-featured">Featured</span>
                                        @endif
                                        @if($product->type == 'rent')
                                            <span class="badge-rent">For Rent</span>
                                        @elseif($product->type == 'sale')
                                            <span class="badge-sale">For Sale</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="product-body">
                                    <a href="{{ route('shop.store', $product->store->id ?? '#') }}" class="product-store">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                            <polyline points="9 22 9 12 15 12 15 22"/>
                                        </svg>
                                        {{ $product->store->name ?? 'Store' }}
                                    </a>

                                    <h4 class="product-title">
                                        <a href="{{ route('shop.product', $product->id) }}">{{ Str::limit($product->name, 45) }}</a>
                                    </h4>

                                    @if(isset($product->reviews_count) && $product->reviews_count > 0)
                                        <div class="product-rating">
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $i <= round($product->average_rating ?? 0) ? '#F59E0B' : 'none' }}" stroke="#F59E0B" stroke-width="2">
                                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="rating-text">{{ number_format($product->average_rating ?? 0, 1) }} ({{ $product->reviews_count }})</span>
                                        </div>
                                    @endif

                                    <div class="product-footer">
                                        <div class="product-price">
                                            @if($product->type == 'rent' && isset($product->rent_period))
                                                <span class="price-amount">${{ number_format($product->price, 2) }}</span>
                                                <span class="price-period">/ {{ $product->rent_period }}</span>
                                            @else
                                                <span class="price-amount">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="product-stock">
                                            @if(($product->quantity ?? 0) > 5)
                                                <span class="stock-in">In Stock</span>
                                            @elseif(($product->quantity ?? 0) > 0)
                                                <span class="stock-low">Only {{ $product->quantity }} left</span>
                                            @else
                                                <span class="stock-out">Out of Stock</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="product-actions">
                                        <button class="quick-view-btn" onclick="quickView({{ $product->id }})">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            Quick View
                                        </button>
                                        <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="M21 15l-5-5L5 21"/>
                                    </svg>
                                </div>
                                <h4>No Products Found</h4>
                                <p>We couldn't find any products matching your criteria.</p>
                                <a href="{{ route('shop.products') }}" class="btn-outline">Clear All Filters</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="products-pagination">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

@push('styles')
<style>
/* ═══════════════════════════════════════════
   OVERLAY SIDEBAR - PRODUCTS PAGE
═══════════════════════════════════════════ */

.dashboard-wrapper {
    position: relative;
    min-height: calc(100vh - 64px);
    background: #F1F5F9;
}

/* Menu Toggle Button */
.menu-toggle {
    position: fixed;
    top: 80px;
    left: 20px;
    z-index: 100;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 10px;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.menu-toggle:hover {
    background: #F8FAFC;
    border-color: gold;
}

.menu-toggle svg {
    stroke: #475569;
    width: 20px;
    height: 20px;
}

/* Sidebar - Fixed Overlay */
.dashboard-sidebar {
    position: fixed;
    top: 0;
    left: -300px;
    width: 280px;
    height: 100vh;
    background: white;
    box-shadow: 4px 0 20px rgba(0,0,0,0.15);
    z-index: 1000;
    transition: left 0.3s ease;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

.dashboard-sidebar.open {
    left: 0;
}

.sidebar-header {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid #F1F5F9;
    position: relative;
}

.company-badge {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, gold, #B8860B);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.company-initial {
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.company-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 2px 0;
}

.company-info p {
    font-size: 12px;
    color: #64748B;
    margin: 0;
}

.close-sidebar {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    color: #94A3B8;
    transition: color 0.2s;
    line-height: 1;
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
    color: #475569;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.nav-item svg {
    flex-shrink: 0;
    stroke: #64748B;
}

.nav-item span {
    flex: 1;
}

.nav-item:hover {
    background: #F8FAFC;
    color: #1E293B;
}

.nav-item:hover svg {
    stroke: gold;
}

.nav-item.active {
    background: #FEF3C7;
    color: gold;
}

.nav-item.active svg {
    stroke: gold;
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid #F1F5F9;
    background: #FAFAFA;
}

.sidebar-stat {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
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
    color: #1E293B;
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
}

.sidebar-overlay.open {
    display: block;
}

/* Main Content */
.dashboard-main {
    width: 100%;
    padding: 32px 0;
    min-height: calc(100vh - 64px);
}

.dashboard-main .container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Welcome Section */
.welcome-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 32px;
}

.welcome-text h1 {
    font-size: 28px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.welcome-text p {
    font-size: 15px;
    color: #475569;
    margin: 0;
}

.welcome-actions {
    display: flex;
    gap: 12px;
}

/* Buttons */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: gold;
    color: #1E293B;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #DAA520;
    transform: translateY(-1px);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    color: #1E293B;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #F8FAFC;
    border-color: #CBD5E1;
}

.btn-outline {
    display: inline-block;
    padding: 10px 20px;
    background: transparent;
    color: gold;
    border: 1px solid gold;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-outline:hover {
    background: gold;
    color: white;
}

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.stat-card:hover {
    border-color: #CBD5E1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 13px;
    font-weight: 500;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon.total { background: #EFF6FF; }
.stat-icon.total svg { stroke: gold; }
.stat-icon.open { background: #FEF3C7; }
.stat-icon.open svg { stroke: #D97706; }
.stat-icon.bids { background: #ECFDF5; }
.stat-icon.bids svg { stroke: #10B981; }
.stat-icon.completed { background: #F3E8FF; }
.stat-icon.completed svg { stroke: #8B5CF6; }

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.quick-card {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.quick-card.active {
    border-color: gold;
    background: #FEF3C7;
}

.quick-card:hover {
    border-color: gold;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.quick-icon {
    width: 44px;
    height: 44px;
    background: #F8FAFC;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-icon svg { stroke: gold; }

.quick-card h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.quick-card p {
    font-size: 12px;
    color: #64748B;
    margin: 0;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
}

/* Filters Card */
.filters-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    position: sticky;
    top: 24px;
    height: fit-content;
}

.filters-header {
    padding: 20px;
    border-bottom: 1px solid #F1F5F9;
}

.filters-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filters-body {
    padding: 20px;
}

.filter-group {
    margin-bottom: 24px;
}

.filter-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}

.search-input-wrap {
    position: relative;
}

.filter-search {
    width: 100%;
    padding: 10px 32px 10px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    color: #1E293B;
    transition: all 0.2s;
}

.filter-search:focus {
    outline: none;
    border-color: gold;
    background: white;
    box-shadow: 0 0 0 3px rgba(255,215,0,0.1);
}

.search-clear {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-options {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.filter-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
    color: #475569;
}

.filter-option:hover {
    background: #F8FAFC;
}

.filter-option.active {
    background: #FEF3C7;
    color: gold;
    font-weight: 500;
}

.filter-option input {
    display: none;
}

/* Price Range */
.price-inputs {
    display: flex;
    align-items: center;
    gap: 12px;
}

.price-input-wrap {
    position: relative;
    flex: 1;
}

.price-currency {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 13px;
    font-weight: 500;
    color: #64748B;
}

.price-input {
    width: 100%;
    padding: 10px 10px 10px 22px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    color: #1E293B;
}

.price-input:focus {
    outline: none;
    border-color: gold;
    background: white;
}

.price-separator {
    color: #94A3B8;
    font-size: 14px;
}

/* Active Filters */
.active-filters-box {
    background: #F8FAFC;
    border-radius: 8px;
    padding: 12px;
    margin: 20px 0 16px;
}

.af-title {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.af-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.af-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #1E293B;
}

.af-chip a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #94A3B8;
    text-decoration: none;
}

.af-chip a:hover {
    color: #EF4444;
}

.af-clear {
    font-size: 12px;
    font-weight: 500;
    color: gold;
    text-decoration: none;
}

.af-clear:hover {
    text-decoration: underline;
}

/* Filter Actions */
.filter-actions {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #E2E8F0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-filter-apply {
    width: 100%;
    padding: 10px;
    background: gold;
    color: #1E293B;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-filter-apply:hover {
    background: #DAA520;
}

.btn-filter-clear {
    width: 100%;
    padding: 10px;
    background: transparent;
    color: #64748B;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-filter-clear:hover {
    border-color: #EF4444;
    color: #EF4444;
}

/* Products Section */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.section-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.section-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.sort-form {
    margin: 0;
}

.sort-select-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.sort-select-wrapper svg {
    position: absolute;
    left: 12px;
    stroke: #94A3B8;
    pointer-events: none;
}

.sort-select {
    padding: 8px 12px 8px 36px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #1E293B;
    cursor: pointer;
    transition: all 0.2s;
}

.sort-select:hover {
    border-color: gold;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    transition: all 0.2s;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -8px rgba(0,0,0,0.1);
    border-color: #CBD5E1;
}

.product-image-wrap {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: #F1F5F9;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-image-placeholder {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    background: #F1F5F9;
}

.product-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    display: flex;
    gap: 8px;
}

.badge-featured {
    padding: 4px 10px;
    background: #F59E0B;
    color: white;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.badge-rent {
    padding: 4px 10px;
    background: #8B5CF6;
    color: white;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.badge-sale {
    padding: 4px 10px;
    background: #10B981;
    color: white;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.product-body {
    padding: 16px;
}

.product-store {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #64748B;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.product-store:hover {
    color: gold;
}

.product-title {
    margin: 0 0 8px 0;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.4;
    color: #0F172A;
}

.product-title a {
    color: inherit;
    text-decoration: none;
}

.product-title a:hover {
    color: gold;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.stars {
    display: flex;
    gap: 2px;
}

.rating-text {
    font-size: 12px;
    color: #64748B;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-top: 1px solid #F1F5F9;
    margin-bottom: 12px;
}

.product-price {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.price-amount {
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
}

.price-period {
    font-size: 11px;
    color: #64748B;
}

.product-stock {
    font-size: 11px;
    font-weight: 600;
}

.stock-in { color: #10B981; }
.stock-low { color: #F59E0B; }
.stock-out { color: #94A3B8; }

.product-actions {
    display: flex;
    gap: 12px;
}

.quick-view-btn, .add-to-cart-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.quick-view-btn {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    color: #475569;
}

.quick-view-btn:hover {
    background: #F1F5F9;
    color: gold;
}

.add-to-cart-btn {
    background: gold;
    border: none;
    color: #1E293B;
}

.add-to-cart-btn:hover {
    background: #DAA520;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.empty-icon {
    margin-bottom: 16px;
}

.empty-state h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1E293B;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 20px;
}

/* Pagination */
.products-pagination {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}

.products-pagination .pagination {
    display: flex;
    gap: 8px;
    list-style: none;
}

.products-pagination .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 8px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    color: #1E293B;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
}

.products-pagination .page-item.active .page-link {
    background: gold;
    border-color: gold;
    color: #1E293B;
}

.products-pagination .page-item .page-link:hover {
    border-color: gold;
    color: gold;
}

/* Desktop: Sidebar always visible */
@media (min-width: 1025px) {
    .menu-toggle {
        display: none;
    }
    
    .dashboard-sidebar {
        left: 0;
        box-shadow: 1px 0 10px rgba(0,0,0,0.05);
    }
    
    .dashboard-main .container {
        padding-left: 300px;
    }
    
    .close-sidebar {
        display: none;
    }
}

/* Mobile/Tablet */
@media (max-width: 1024px) {
    .menu-toggle {
        display: flex;
    }
    
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 900px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .filters-card {
        position: static;
    }
    
    .dashboard-main .container {
        padding-left: 24px;
    }
}

@media (max-width: 768px) {
    .dashboard-main {
        padding: 20px 0;
    }
    
    .dashboard-main .container {
        padding: 0 16px;
    }
    
    .welcome-section {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-actions {
        width: 100%;
        justify-content: center;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 480px) {
    .welcome-actions {
        flex-direction: column;
    }
    
    .btn-primary, .btn-secondary {
        justify-content: center;
        width: 100%;
    }
    
    .price-inputs {
        flex-direction: column;
        gap: 8px;
    }
    
    .price-separator {
        display: none;
    }
    
    .product-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('dashboardSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
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

function quickView(productId) {
    window.location.href = '/shop/product/' + productId;
}

function addToCart(productId) {
    fetch('{{ route("shop.add-to-cart", ["productId" => ":productId"]) }}'.replace(':productId', productId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('Product added to cart!');
          }
      }).catch(() => {
          alert('Added to cart!');
      });
}
</script>
@endpush
@endsection