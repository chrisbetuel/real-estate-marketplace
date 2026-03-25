@extends('layouts.app')

@section('title', 'Store Dashboard - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">Store <span style="color: var(--gold-accent);">Dashboard</span></h1>
            <p class="lead" style="color: var(--primary-dark); opacity: 0.8;">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm" style="background: var(--primary-dark); color: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="display-6">{{ $stats['total_products'] ?? 0 }}</p>
                    <a href="{{ route('products.index') }}" class="text-white">View Products <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm" style="background: var(--gold-accent); color: var(--primary-dark); border: none; border-radius: 20px;">
                <div class="card-body">
                    <h5 class="card-title">Active Sales</h5>
                    <p class="display-6">{{ $stats['active_products'] ?? 0 }}</p>
                    <a href="{{ route('products.index') }}?status=active" style="color: var(--primary-dark);">View Active <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm" style="background: var(--soft-white); color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 20px;">
                <div class="card-body">
                    <h5 class="card-title">Orders Received</h5>
                    <p class="display-6">0</p>
                    <a href="{{ route('stores.my') }}" style="color: var(--primary-dark);">View Orders <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm" style="background: var(--primary-dark); color: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body">
                    <h5 class="card-title">Reviews</h5>
<p class="display-6">0.0 <i class="fas fa-star text-warning"></i></p>
                    <a href="{{ route('stores.my') }}" class="text-white">View Reviews <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Properties Card -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm" style="background: var(--soft-white); color: var(--primary-dark); border: 2px solid var(--gold-accent); border-radius: 20px;">
            <div class="card-body">
                <h5 class="card-title">Properties</h5>
                <p class="display-6">{{ Auth::user()->properties()->count() }}</p>
                <a href="{{ route('properties.index') }}" style="color: var(--primary-dark);">Browse Properties <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold" style="color: var(--primary-dark);">Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('stores.create') }}" class="btn" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-plus-circle me-2"></i>Add Product
                        </a>
                        <a href="{{ route('products.index') }}" class="btn" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-list me-2"></i>Manage Products
                        </a>
                        <a href="{{ route('stores.edit', $store) }}" class="btn" style="background: transparent; color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-store me-2"></i>Edit Store Info (Logo, Description)
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold" style="color: var(--primary-dark);">Recent Products</h5>
                </div>
                <div class="card-body p-4">
                    @if($recentProducts->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentProducts as $product)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-1" style="color: var(--primary-dark);">{{ $product->title }}</h6>
                                            <small class="text-muted">
                                                ${{ number_format($product->price, 2) }} | {{ $product->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 10px;">
                                            View
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No products yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
