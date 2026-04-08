@extends('layouts.app')

@section('title', 'Browse Stores - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-dark);">Browse <span style="color: var(--gold-accent);">Stores</span></h1>
            <p class="lead" style="color: var(--primary-dark); opacity: 0.8;">Find quality products from trusted hardware stores</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-4">
                    <form action="{{ route('stores.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Search Stores</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Store name or description..." value="{{ request('keyword') }}" style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Specialization</label>
                            <select name="specialization" class="form-select" style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                <option value="">All Specializations</option>
                                <option value="Engineer" {{ request('specialization') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                <option value="Architect" {{ request('specialization') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                <option value="Designer" {{ request('specialization') == 'Designer' ? 'selected' : '' }}>Designer</option>
                                <option value="Electrician" {{ request('specialization') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                <option value="Plumber" {{ request('specialization') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                <option value="Carpenter" {{ request('specialization') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="City or region..." value="{{ request('location') }}" style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn w-100" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 12px; font-weight: 600;">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stores Grid -->
    <div class="row">
        @forelse($stores as $store)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; overflow: hidden;">
                <!-- Store Logo/Image -->
                <div class="text-center pt-4">
                    <img src="{{ $store->logo ?? 'https://via.placeholder.com/100x100/0F172A/F8F8F9?text=' . substr($store->store_name, 0, 1) }}" 
                         alt="{{ $store->store_name }}"
                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-accent);">
                </div>
                
                <div class="card-body p-4">
                    <!-- Store Name -->
                    <h3 class="h5 fw-bold text-center mb-2" style="color: var(--primary-dark);">{{ $store->store_name }}</h3>
                    
                    <!-- Verification Badge -->
                    @if($store->is_verified)
                    <div class="text-center mb-2">
                        <span class="badge" style="background: #28a745; color: white; padding: 5px 15px; border-radius: 50px;">
                            <i class="fas fa-check-circle me-1"></i>Verified
                        </span>
                    </div>
                    @endif
                    
                    <!-- Specialization -->
                    <p class="text-center small mb-2" style="color: var(--gold-accent); font-weight: 600;">
                        <i class="fas fa-tag me-1"></i>{{ $store->specialization ?? 'General Store' }}
                    </p>
                    
                    <!-- Location -->
                    <p class="small text-center mb-3" style="color: var(--primary-dark); opacity: 0.7;">
                        <i class="fas fa-map-marker-alt me-1" style="color: var(--gold-accent);"></i>
                        {{ $store->city }}, {{ $store->state }}
                    </p>
                    
                    <!-- Contact Info -->
                    <div class="mb-3">
                        <p class="small mb-1"><i class="fas fa-phone me-2" style="color: var(--gold-accent);"></i>{{ $store->store_phone }}</p>
                        @if($store->store_email)
                        <p class="small mb-0"><i class="fas fa-envelope me-2" style="color: var(--gold-accent);"></i>{{ $store->store_email }}</p>
                        @endif
                    </div>
                    
                    <!-- Products Count -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small" style="color: var(--primary-dark); opacity: 0.7;">
                            <i class="fas fa-box me-1"></i>{{ $store->products_count ?? 0 }} Products
                        </span>
                    </div>
                    
                    <!-- View Store Button -->
                    <a href="{{ route('stores.show', $store) }}" class="btn w-100" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 10px; font-weight: 600;">
                        Visit Store <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-store fa-4x mb-3" style="color: var(--gold-accent); opacity: 0.5;"></i>
                <h3 style="color: var(--primary-dark);">No Stores Found</h3>
                <p style="color: var(--primary-dark); opacity: 0.7;">Try adjusting your search filters or check back later.</p>
                @auth
                    @if(Auth::user()->user_type == 'store_owner')
                    <a href="{{ route('stores.create') }}" class="btn btn-lg mt-3" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 50px; padding: 12px 40px; font-weight: 600;">
                        Register Your Store <i class="fas fa-plus-circle ms-2"></i>
                    </a>
                    @endif
                @endauth
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            {{ $stores->links() }}
        </div>
    </div>
</div>
@endsection