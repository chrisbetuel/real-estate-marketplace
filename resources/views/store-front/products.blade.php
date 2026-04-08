@extends('layouts.app')

@section('title', 'Products - Oweru')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-semibold mb-2">Products</h1>
            <p class="text-muted">Browse products from our trusted stores</p>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('shop.products') }}">
                        <div class="mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" placeholder="Search products...">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom w-100">Apply Filters</button>
                        @if(request()->anyFilled(['search', 'category', 'sort']))
                            <a href="{{ route('shop.products') }}" class="btn btn-outline-custom w-100 mt-2">Clear Filters</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @php
                                $images = json_decode($product->images, true);
                            @endphp
                            @if($images && count($images) > 0)
                                <img src="{{ asset('storage/' . $images[0]) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 180px; object-fit: cover;">
                            @else
                                <div style="height: 180px; background: var(--gray-200); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image fa-3x" style="color: var(--gray-500);"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($product->name, 40) }}</h6>
<p class="text-oweru-gold fw-semibold">${{ number_format($product->price_sale ?? $product->price_rent ?? $product->price ?? 0, 2) }}</p>
                                @if($product->stock > 0)
                                    <span class="badge bg-success mb-2">In Stock</span>
                                @else
                                    <span class="badge bg-secondary mb-2">Out of Stock</span>
                                @endif
                                <p class="small text-muted">{{ $product->store->name }}</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('shop.product', $product->id) }}" class="btn btn-outline-custom w-100 mb-2">
                                    View Details
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{ route('shop.add-to-cart', $product->id) }}" method="POST">
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
                        <h5>No Products Found</h5>
                        <p class="text-muted">Try adjusting your filters or search terms.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
    .badge-success {
        background: #ECFDF5;
        color: #059669;
    }
    .badge-secondary {
        background: var(--gray-200);
        color: var(--gray-600);
    }
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
</style>
@endpush
@endsection