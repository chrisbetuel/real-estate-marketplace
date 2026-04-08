@extends('layouts.app')

@section('title', $store->store_name . ' - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--primary-dark);">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('stores.index') }}" style="color: var(--primary-dark);">Stores</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: var(--gold-accent);">{{ $store->store_name }}</li>
        </ol>
    </nav>

    <!-- Store Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; overflow: hidden;">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $store->logo ?? 'https://via.placeholder.com/150x150/0F172A/F8F8F9?text=' . substr($store->store_name, 0, 1) }}" 
                                 alt="{{ $store->store_name }}"
                                 style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid var(--gold-accent);">
                            @if($store->images && count($store->images) > 0)
                                <div class="mt-3">
                                    <small class="text-muted">Gallery</small>
                                    <div class="d-flex gap-1 mt-1">
                                        @foreach(array_slice($store->images, 0, 4) as $image)
                                            <img src="{{ $image }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; cursor: pointer;" onclick="openImageModal('{{ $image }}')" title="Click to enlarge">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <h1 class="display-6 fw-bold mb-2" style="color: var(--primary-dark);">{{ $store->store_name }}</h1>
                            
                            @if($store->is_verified)
                            <span class="badge mb-2" style="background: #28a745; color: white; padding: 8px 20px; border-radius: 50px;">
                                <i class="fas fa-check-circle me-1"></i>Verified Store
                            </span>
                            @endif
                            
                            <p class="mb-2" style="color: var(--gold-accent); font-weight: 600;">
                                <i class="fas fa-tag me-2"></i>{{ $store->specialization ?? 'General Store' }}
                            </p>
                            
                            <p class="mb-2" style="color: var(--primary-dark); opacity: 0.8;">
                                <i class="fas fa-map-marker-alt me-2" style="color: var(--gold-accent);"></i>{{ $store->store_address }}
                            </p>
                            
                            <p class="mb-2">
                                <i class="fas fa-phone me-2" style="color: var(--gold-accent);"></i>{{ $store->store_phone }}
                            </p>
                            
                            @if($store->store_email)
                            <p class="mb-0">
                                <i class="fas fa-envelope me-2" style="color: var(--gold-accent);"></i>{{ $store->store_email }}
                            </p>
                            @endif
                        </div>
                        <div class="col-md-3 text-end">
                            @auth
                                @if(Auth::user()->user_type == 'client')
                                <!-- Simple GET link - now works because route is GET -->
                                <a href="{{ route('messages.start-store', $store) }}" class="btn w-100 mb-2" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 12px; font-weight: 600; text-decoration: none; display: inline-block;">
                                    <i class="fas fa-envelope me-2"></i>Contact Store
                                </a>
                                @endif
                                
                                @if(Auth::user()->user_type == 'store_owner' && Auth::user()->store && Auth::user()->store->id == $store->id)
                                <a href="{{ route('stores.edit', $store) }}" class="btn w-100" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 12px; font-weight: 600; text-decoration: none; display: inline-block;">
                                    <i class="fas fa-edit me-2"></i>Edit Store
                                </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                    
                    @if($store->description)
                    <hr class="my-4" style="color: var(--light-grey);">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">About the Store</h5>
                            <p style="color: var(--primary-dark); opacity: 0.8; line-height: 1.8;">{{ $store->description }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($store->business_hours)
                    <hr class="my-4" style="color: var(--light-grey);">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">Business Hours</h5>
                            <div class="row">
                                @foreach($store->business_hours as $day => $hours)
                                <div class="col-md-3 mb-2">
                                    <span class="fw-semibold" style="color: var(--primary-dark);">{{ $day }}:</span>
                                    <span style="color: var(--primary-dark); opacity: 0.8;">{{ $hours }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Store Products -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-4" style="color: var(--primary-dark);">Products from <span style="color: var(--gold-accent);">{{ $store->store_name }}</span></h2>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; overflow: hidden;">
                <div class="product-image" style="height: 200px; background-image: url('{{ $product->images[0] ?? 'https://via.placeholder.com/300x200/0F172A/F8F8F9' }}'); background-size: cover; background-position: center; position: relative;">
                    <span class="badge" style="position: absolute; top: 15px; right: 15px; background: var(--gold-accent); color: var(--primary-dark); padding: 5px 15px; border-radius: 50px; font-weight: 600;">
                        {{ ucfirst($product->type) }}
                    </span>
                </div>
                <div class="card-body p-3">
                    <h5 class="fw-bold mb-2" style="color: var(--primary-dark);">{{ $product->name }}</h5>
                    <p class="small mb-2" style="color: var(--primary-dark); opacity: 0.7;">{{ Str::limit($product->description, 60) }}</p>
                    
                    @if($product->price_sale)
                        <p class="fw-bold mb-1" style="color: var(--gold-accent);">Sale: ${{ number_format($product->price_sale) }}</p>
                    @endif
                    @if($product->price_rent)
                        <p class="fw-bold mb-2" style="color: var(--gold-accent);">Rent: ${{ number_format($product->price_rent) }}/{{ $product->rent_period }}</p>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small" style="color: var(--primary-dark); opacity: 0.6;">
                            <i class="fas fa-box me-1"></i>Qty: {{ $product->quantity }}
                        </span>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 8px 20px; text-decoration: none;">
                            View
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-4">
                <p style="color: var(--primary-dark); opacity: 0.7;">No products available from this store yet.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection