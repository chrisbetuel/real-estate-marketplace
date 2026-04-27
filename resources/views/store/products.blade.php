@extends('layouts.app')

@section('title', 'My Products - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-left">
                <h1>My Products</h1>
                <p>Manage your product inventory and track sales</p>
            </div>
            <div class="header-right">
                <a href="{{ route('store-owner.products.create') }}" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Add New Product
                </a>
            </div>
        </div>

        <!-- Stats Summary -->
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
                    <span class="stat-label">Active Products</span>
                    <span class="stat-value">{{ $products->where('is_active', true)->count() }}</span>
                </div>
                <div class="stat-icon active">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Sales</span>
                    <span class="stat-value">{{ $products->sum('sales_count') }}</span>
                </div>
                <div class="stat-icon sales">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Low Stock Items</span>
                    <span class="stat-value">{{ $products->where('stock', '<=', 10)->where('stock', '>', 0)->count() }}</span>
                </div>
                <div class="stat-icon low-stock">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Products Table Card -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3>Product Inventory</h3>
                    <p>Manage all your products in one place</p>
                </div>
                <div class="card-actions">
                    <div class="search-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" id="productSearch" placeholder="Search products..." class="search-input">
                    </div>
                    <div class="filter-dropdown">
                        <select id="statusFilter" class="filter-select">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="product-cell">
                                        <div class="product-info">
                                            <div class="product-image">
                                                @php
                                                    $images = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);
                                                @endphp
                                                @if($images && count($images) > 0)
                                                    <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}">
                                                @else
                                                    <div class="image-placeholder">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.5">
                                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                                            <path d="M21 15l-5-5L5 21"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-details">
                                                <div class="product-name">{{ $product->name }}</div>
                                                <div class="product-meta">ID: #{{ $product->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price-cell">
                                        <span class="price-amount">${{ number_format($product->price, 2) }}</span>
                                        @if($product->compare_price)
                                            <span class="compare-price">${{ number_format($product->compare_price, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="stock-cell">
                                        @if($product->stock <= 0)
                                            <span class="stock-badge out">Out of Stock</span>
                                        @elseif($product->stock <= 10)
                                            <span class="stock-badge low">Only {{ $product->stock }} left</span>
                                        @else
                                            <span class="stock-badge in">{{ $product->stock }} in stock</span>
                                        @endif
                                    </td>
                                    <td class="category-cell">
                                        <span class="category-badge">{{ $product->category ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td class="sales-cell">
                                        <div class="sales-info">
                                            <span class="sales-count">{{ $product->sales_count ?? 0 }}</span>
                                            <span class="sales-label">sold</span>
                                        </div>
                                    </td>
                                    <td class="status-cell">
                                        @if($product->is_active)
                                            <span class="status-badge active">
                                                <span class="status-dot"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="status-badge inactive">
                                                <span class="status-dot"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="actions-cell">
                                        <div class="action-buttons">
                                            <a href="{{ route('store-owner.products.edit', $product->id) }}" class="action-btn edit" title="Edit Product">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                                    <path d="M4 20h16"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('store-owner.products.delete', $product->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" onclick="return confirm('Delete this product? This action cannot be undone.')" title="Delete Product">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M3 6h18"/>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <a href="{{ route('shop.product', $product->id) }}" class="action-btn view" target="_blank" title="View Product">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="pagination-container">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M3 9h18"/>
                                <path d="M9 21V9"/>
                            </svg>
                        </div>
                        <h4>No Products Yet</h4>
                        <p>Start adding products to your store and grow your business.</p>
                        <a href="{{ route('store-owner.products.create') }}" class="btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="tips-card">
            <div class="tips-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4M12 8h.01"/>
                </svg>
            </div>
            <div class="tips-content">
                <h4>Pro Tips</h4>
                <p>High-quality product images and detailed descriptions can increase sales by up to 78%.</p>
            </div>
            <a href="{{ route('store-owner.products.create') }}" class="tips-btn">
                Add New Product
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════
   MY PRODUCTS PAGE - AMERICAN STYLE
   Clean | Bold | Data-Driven | Functional
═══════════════════════════════════════════ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-container {
    background: #F1F5F9;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Typography */
h1, h2, h3, h4 {
    font-weight: 600;
    letter-spacing: -0.02em;
}

/* Header Section */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 32px;
}

.header-left h1 {
    font-size: 28px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.header-left p {
    font-size: 15px;
    color: #475569;
    margin: 0;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #2563EB;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
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
.stat-icon.total svg { stroke: #2563EB; }
.stat-icon.active { background: #ECFDF5; }
.stat-icon.active svg { stroke: #10B981; }
.stat-icon.sales { background: #FEF3C7; }
.stat-icon.sales svg { stroke: #F59E0B; }
.stat-icon.low-stock { background: #FEF2F2; }
.stat-icon.low-stock svg { stroke: #EF4444; }

/* Card */
.card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    margin-bottom: 24px;
}

.card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.card-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.card-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.card-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.search-box {
    position: relative;
}

.search-box svg {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    stroke: #94A3B8;
}

.search-input {
    padding: 8px 12px 8px 36px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    width: 220px;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #2563EB;
    background: white;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.filter-select {
    padding: 8px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    color: #1E293B;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-select:focus {
    outline: none;
    border-color: #2563EB;
}

.card-body {
    padding: 0;
}

/* Product Table */
.product-table {
    width: 100%;
    border-collapse: collapse;
}

.product-table thead th {
    text-align: left;
    padding: 16px 20px;
    background: #F8FAFC;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #E2E8F0;
}

.product-table tbody tr {
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
}

.product-table tbody tr:hover {
    background: #F8FAFC;
}

.product-table tbody td {
    padding: 16px 20px;
    vertical-align: middle;
}

/* Product Cell */
.product-cell {
    min-width: 280px;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.product-image {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    overflow: hidden;
    background: #F1F5F9;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #F1F5F9;
}

.product-details {
    flex: 1;
}

.product-name {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin-bottom: 4px;
}

.product-meta {
    font-size: 11px;
    color: #94A3B8;
}

/* Price Cell */
.price-cell {
    min-width: 120px;
}

.price-amount {
    font-size: 15px;
    font-weight: 700;
    color: #0F172A;
}

.compare-price {
    font-size: 12px;
    color: #94A3B8;
    text-decoration: line-through;
    margin-left: 6px;
}

/* Stock Cell */
.stock-cell {
    min-width: 120px;
}

.stock-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
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

/* Category Cell */
.category-cell {
    min-width: 120px;
}

.category-badge {
    display: inline-block;
    padding: 4px 10px;
    background: #F1F5F9;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #475569;
}

/* Sales Cell */
.sales-cell {
    min-width: 80px;
}

.sales-info {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.sales-count {
    font-size: 14px;
    font-weight: 700;
    color: #0F172A;
}

.sales-label {
    font-size: 11px;
    color: #94A3B8;
}

/* Status Cell */
.status-cell {
    min-width: 100px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.active {
    background: #ECFDF5;
    color: #059669;
}

.status-badge.inactive {
    background: #F1F5F9;
    color: #64748B;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* Actions Cell */
.actions-cell {
    min-width: 100px;
}

.action-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    background: transparent;
}

.action-btn.edit {
    color: #64748B;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
}

.action-btn.edit:hover {
    background: #EFF6FF;
    border-color: #2563EB;
    color: #2563EB;
}

.action-btn.delete {
    color: #64748B;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
}

.action-btn.delete:hover {
    background: #FEF2F2;
    border-color: #EF4444;
    color: #EF4444;
}

.action-btn.view {
    color: #64748B;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
}

.action-btn.view:hover {
    background: #F8FAFC;
    border-color: #10B981;
    color: #10B981;
}

.delete-form {
    margin: 0;
}

/* Pagination */
.pagination-container {
    padding: 20px 24px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    justify-content: center;
}

.pagination-container .pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination-container .page-item .page-link {
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

.pagination-container .page-item.active .page-link {
    background: #2563EB;
    border-color: #2563EB;
    color: white;
}

.pagination-container .page-item .page-link:hover {
    border-color: #2563EB;
    color: #2563EB;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 64px 24px;
}

.empty-icon {
    margin-bottom: 20px;
}

.empty-state h4 {
    font-size: 18px;
    font-weight: 600;
    color: #1E293B;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: #64748B;
    margin-bottom: 24px;
}

/* Tips Card */
.tips-card {
    background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
    border-radius: 12px;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.tips-icon {
    width: 48px;
    height: 48px;
    background: rgba(37,99,235,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tips-icon svg {
    stroke: #60A5FA;
}

.tips-content {
    flex: 1;
}

.tips-content h4 {
    font-size: 14px;
    font-weight: 600;
    color: white;
    margin: 0 0 4px 0;
}

.tips-content p {
    font-size: 13px;
    color: #94A3B8;
    margin: 0;
}

.tips-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #2563EB;
    color: white;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.tips-btn:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 900px) {
    .table-responsive {
        overflow-x: auto;
    }
    
    .product-table {
        min-width: 800px;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 24px 0;
    }
    
    .container {
        padding: 0 16px;
    }
    
    .header-section {
        flex-direction: column;
        text-align: center;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .card-actions {
        width: 100%;
        flex-direction: column;
    }
    
    .search-box {
        width: 100%;
    }
    
    .search-input {
        width: 100%;
    }
    
    .filter-select {
        width: 100%;
    }
    
    .tips-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('productSearch');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('.product-table tbody tr');
    
    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const statusValue = statusFilter ? statusFilter.value : 'all';
        
        tableRows.forEach(row => {
            const productName = row.querySelector('.product-name')?.textContent.toLowerCase() || '';
            const statusBadge = row.querySelector('.status-badge');
            const isActive = statusBadge?.classList.contains('active');
            
            let matchesSearch = productName.includes(searchTerm);
            let matchesStatus = statusValue === 'all' || 
                (statusValue === 'active' && isActive) || 
                (statusValue === 'inactive' && !isActive);
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterTable);
    }
});
</script>
@endpush