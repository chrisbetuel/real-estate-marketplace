@extends('layouts.app')

@section('title', $store->name . ' - Oweru')

@section('content')
<div class="container py-5">
    <!-- Store Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" 
                     alt="{{ $store->name }}" 
                     class="store-logo">
            @else
                <div class="store-logo-placeholder">
                    <i class="fas fa-store fa-3x"></i>
                </div>
            @endif
            <h1 class="fw-semibold mt-3">{{ $store->name }}</h1>
            <p class="text-muted">{{ $store->description }}</p>
            <div class="store-info">
                <span><i class="fas fa-envelope me-1"></i> {{ $store->email }}</span>
                @if($store->phone)
                    <span><i class="fas fa-phone me-1"></i> {{ $store->phone }}</span>
                @endif
                @if($store->address)
                    <span><i class="fas fa-map-marker-alt me-1"></i> {{ $store->address }}, {{ $store->city }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Products from {{ $store->name }}</h3>
        </div>
        
        @forelse($store->products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 product-card">
                    @php
                        $images = json_decode($product->images, true);
                    @endphp
                    <div class="product-image">
                        @if($images && count($images) > 0)
                            <img src="{{ asset('storage/' . $images[0]) }}" 
                                 alt="{{ $product->name }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image fa-3x"></i>
                            </div>
                        @endif
                        @if($product->stock <= 0)
                            <div class="out-of-stock-badge">Out of Stock</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($product->name, 40) }}</h6>
                        <div class="product-price">${{ number_format($product->price, 2) }}</div>
                        @if($product->stock > 0 && $product->stock <= 10)
                            <div class="stock-warning">Only {{ $product->stock }} left!</div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('shop.product', $product->id) }}" class="btn btn-outline-custom w-100 mb-2">
                            View Details
                        </a>
                        @if($product->stock > 0)
                            <form action="{{ route('shop.add-to-cart', $product->id) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary-custom w-100">
                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>No Products Yet</h5>
                <p class="text-muted">This store hasn't added any products yet.</p>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .store-logo {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .store-logo-placeholder {
        width: 100px;
        height: 100px;
        background: var(--gray-200);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .store-info {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
        font-size: 0.85rem;
        color: var(--gray-600);
    }
    
    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .product-image {
        height: 180px;
        overflow: hidden;
        position: relative;
        background: var(--gray-100);
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-400);
    }
    
    .out-of-stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
    }
    
    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--oweru-gold);
        margin: 8px 0;
    }
    
    .stock-warning {
        font-size: 0.7rem;
        color: #f59e0b;
    }
    
    .btn-primary-custom {
        background: var(--oweru-gold);
        border: none;
        color: var(--oweru-dark);
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: var(--oweru-gold-dark);
        transform: translateY(-1px);
    }
    
    .btn-outline-custom {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .btn-outline-custom:hover {
        border-color: var(--oweru-gold);
        color: var(--oweru-gold);
    }
</style>
@endpush
@endsection