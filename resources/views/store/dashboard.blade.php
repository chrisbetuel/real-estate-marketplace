@extends('layouts.app')

@section('title', 'Store Dashboard - BuildConnect')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="position-relative d-inline-block">
                <h1 class="fw-bold mb-2" style="color: var(--brand-dark);">Store Dashboard</h1>
                <div style="position: absolute; bottom: -8px; left: 0; width: 60px; height: 3px; background: var(--brand-gold); border-radius: 3px;"></div>
            </div>
            <p class="text-muted mt-3">Manage your store, products, and track sales performance</p>
        </div>
    </div>

    <!-- Store Info & Stats -->
    <div class="row mb-5">
        <!-- Store Info Card -->
        <div class="col-md-4 mb-4">
            <div class="store-info-card">
                <div class="store-avatar mb-4">
                    @if($store && $store->logo)
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}">
                    @else
                        <div class="store-avatar-placeholder">
                            <i class="fas fa-store"></i>
                        </div>
                    @endif
                </div>
                <h3 class="store-name">{{ $store->name ?? 'Your Store' }}</h3>
                <p class="store-email">{{ $store->email ?? 'No email set' }}</p>
                <a href="{{ route('store-owner.profile.edit') }}" class="btn-edit-store">
                    <i class="fas fa-edit me-2"></i>Edit Store Profile
                </a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-number">{{ $stats['total_products'] }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-number">{{ $stats['active_products'] }}</div>
                        <div class="stat-label">Active Products</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">{{ $stats['total_sales'] }}</div>
                        <div class="stat-label">Total Sales</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['total_views']) }}</div>
                        <div class="stat-label">Total Views</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="row">
        <div class="col-12">
            <div class="products-card">
                <div class="products-header">
                    <div>
                        <h5 class="mb-1">Your Products</h5>
                        <p class="text-muted small mb-0">Manage your product inventory</p>
                    </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('store-owner.products.create') }}" class="btn-add-product">
                                <i class="fas fa-plus me-2"></i>Add Product
                            </a>
                            <a href="{{ route('store-owner.orders') }}" class="btn" style="background: var(--success); color: white;">
                                <i class="fas fa-box me-2"></i>My Orders
                            </a>
                        </div>
                </div>
                
                <div class="products-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="products-table">
                                <thead>
                                    32
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Sales</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td class="product-info">
                                                <div class="product-image">
                                                    @php
                                                        $images = json_decode($product->images, true);
                                                    @endphp
                                                    @if($images && count($images) > 0)
                                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}">
                                                    @else
                                                        <div class="no-image">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="product-details">
                                                    <span class="product-name">{{ $product->name }}</span>
                                                    <span class="product-category">{{ $product->category }}</span>
                                                </div>
                                            </td>
                                            <td class="product-price">${{ number_format($product->price, 2) }}</td>
                                            <td class="product-stock">
                                                @if($product->stock <= 5 && $product->stock > 0)
                                                    <span class="stock-low">{{ $product->stock }} left</span>
                                                @elseif($product->stock <= 0)
                                                    <span class="stock-out">Out of stock</span>
                                                @else
                                                    {{ $product->stock }}
                                                @endif
                                            </td>
                                            <td class="product-sales">{{ $product->sales_count }}</td>
                                            <td class="product-status">
                                                @if($product->is_active)
                                                    <span class="status-active">Active</span>
                                                @else
                                                    <span class="status-inactive">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="product-actions">
                                                <a href="{{ route('store-owner.products.edit', $product->id) }}" class="btn-action" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('store-owner.products.delete', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Delete this product?')" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $products->links() }}
                            </div>
                        @else
                            <div class="empty-products">
                                <div class="empty-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h6>No Products Yet</h6>
                                <p>Start adding products to your store</p>
                                <a href="{{ route('store-owner.products.create') }}" class="btn-add-first">
                                    <i class="fas fa-plus me-2"></i>Add Your First Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Store Info Card */
    .store-info-card {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .store-info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -12px rgba(0,0,0,0.1);
    }
    
    .store-avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }
    
    .store-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--brand-gold);
    }
    
    .store-avatar-placeholder {
        width: 100%;
        height: 100%;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid var(--brand-gold);
    }
    
    .store-avatar-placeholder i {
        font-size: 3rem;
        color: var(--gray-400);
    }
    
    .store-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--brand-dark);
        margin: 1rem 0 0.25rem;
    }
    
    .store-email {
        font-size: 0.85rem;
        color: var(--gray-500);
        margin-bottom: 1.5rem;
    }
    
    .btn-edit-store {
        display: inline-flex;
        align-items: center;
        padding: 8px 20px;
        background: transparent;
        border: 1px solid var(--brand-gold);
        color: var(--brand-gold);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-edit-store:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
        transform: translateY(-2px);
    }
    
    /* Stats Cards */
    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid var(--gray-200);
        transition: all 0.2s;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        border-color: var(--brand-gold);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .stat-icon i {
        font-size: 1.5rem;
        color: var(--brand-gold);
    }
    
    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--brand-gold);
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-600);
    }
    
    /* Products Card */
    .products-card {
        background: var(--white);
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        overflow: hidden;
    }
    
    .products-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .btn-add-product {
        display: inline-flex;
        align-items: center;
        padding: 8px 20px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-add-product:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
    }
    
    .products-body {
        padding: 0;
    }
    
    .products-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .products-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--gray-600);
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
    }
    
    .products-table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .product-image {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        background: var(--gray-100);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .no-image i {
        font-size: 1.2rem;
        color: var(--gray-400);
    }
    
    .product-details {
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 4px;
    }
    
    .product-category {
        font-size: 0.7rem;
        color: var(--gray-500);
    }
    
    .product-price {
        font-weight: 600;
        color: var(--brand-gold);
    }
    
    .stock-low {
        color: #f59e0b;
        font-weight: 500;
    }
    
    .stock-out {
        color: var(--danger);
        font-weight: 500;
    }
    
    .status-active {
        display: inline-block;
        padding: 4px 12px;
        background: #ECFDF5;
        color: #059669;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .status-inactive {
        display: inline-block;
        padding: 4px 12px;
        background: var(--gray-200);
        color: var(--gray-600);
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .product-actions {
        white-space: nowrap;
    }
    
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: transparent;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        color: var(--gray-600);
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .btn-action:hover {
        border-color: var(--brand-gold);
        color: var(--brand-gold);
    }
    
    .btn-delete:hover {
        border-color: var(--danger);
        color: var(--danger);
    }
    
    /* Empty State */
    .empty-products {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .empty-icon i {
        font-size: 2.5rem;
        color: var(--brand-gold);
    }
    
    .empty-products h6 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-products p {
        font-size: 0.85rem;
        color: var(--gray-500);
        margin-bottom: 1.5rem;
    }
    
    .btn-add-first {
        display: inline-flex;
        align-items: center;
        padding: 10px 24px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-add-first:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
    }
</style>
@endpush
@endsection