@extends('layouts.app')

@section('title', 'Products - Real Estate Marketplace')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Products</h1>
            
            <!-- Search and Filter Bar -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control" placeholder="Search products..." value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="sale" {{ request('category') == 'sale' ? 'selected' : '' }}>For Sale</option>
                                <option value="rent" {{ request('category') == 'rent' ? 'selected' : '' }}>For Rent</option>
                                <option value="both" {{ request('category') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="location" class="form-control" placeholder="Location..." value="{{ request('location') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="row">
                @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $product->images[0] ?? 'https://via.placeholder.com/300x200' }}" 
                             class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            
                            <div class="mb-2">
                                @if($product->price_sale)
                                    <span class="badge bg-primary">Sale: ${{ number_format($product->price_sale) }}</span>
                                @endif
                                @if($product->price_rent)
                                    <span class="badge bg-success">Rent: ${{ number_format($product->price_rent) }}/{{ $product->rent_period }}</span>
                                @endif
                            </div>
                            
                            <p class="small text-muted mb-2">
                                <i class="fas fa-store me-1"></i> {{ $product->store->store_name }}
                            </p>
                            
                            <p class="small text-muted mb-3">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $product->store->city }}, {{ $product->store->state }}
                            </p>
                            
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> No products found.
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection