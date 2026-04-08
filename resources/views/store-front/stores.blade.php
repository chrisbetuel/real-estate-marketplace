@extends('layouts.app')

@section('title', 'Stores - BuildConnect')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="position-relative d-inline-block">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--brand-dark);">
                    Our <span style="color: var(--brand-gold);">Stores</span>
                </h1>
                <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: var(--brand-gold); border-radius: 3px;"></div>
            </div>
            <p class="lead mt-4" style="color: var(--gray-600); max-width: 600px; margin: 0 auto;">
                Discover quality products from our trusted partner stores
            </p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="search-card">
                <form method="GET" action="{{ route('shop.stores') }}">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="search-input" 
                               placeholder="Search stores by name or location..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="search-btn">Search</button>
                    </div>
                </form>
                
                @if(request('search'))
                    <div class="active-filter mt-3">
                        <span class="filter-badge">
                            Searching for: "{{ request('search') }}"
                            <a href="{{ route('shop.stores') }}" class="clear-filter">×</a>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stores Grid -->
    <div class="row">
        @forelse($stores as $store)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="store-card">
                    <div class="store-card-inner">
                        <!-- Store Logo -->
                        <div class="store-logo">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}">
                            @else
                                <div class="store-logo-placeholder">
                                    <i class="fas fa-store"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Store Info -->
                        <div class="store-info">
                            <h3 class="store-name">{{ $store->name }}</h3>
                            <p class="store-description">{{ Str::limit($store->description, 80) }}</p>
                            
                            <!-- Store Stats -->
                            <div class="store-stats">
                                <div class="stat-item">
                                    <i class="fas fa-box"></i>
                                    <span>{{ $store->products_count }} Products</span>
                                </div>
                                @if($store->city)
                                <div class="stat-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $store->city }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Visit Button -->
                            <a href="{{ route('shop.store', $store->id) }}" class="btn-visit-store">
                                Visit Store
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>No Stores Found</h3>
                    <p>We couldn't find any stores matching "{{ request('search') }}".</p>
                    <a href="{{ route('shop.stores') }}" class="btn-clear-search">
                        <i class="fas fa-arrow-left me-2"></i>Clear Search
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stores->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                {{ $stores->links() }}
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* Search Card */
    .search-card {
        background: var(--white);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid var(--gray-200);
    }
    
    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .search-icon {
        position: absolute;
        left: 16px;
        color: var(--gray-500);
        font-size: 1rem;
        pointer-events: none;
        z-index: 1;
    }
    
    .search-input {
        width: 100%;
        padding: 14px 120px 14px 44px;
        border: 1px solid var(--gray-300);
        border-radius: 14px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background: var(--white);
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--brand-gold);
        box-shadow: 0 0 0 3px rgba(201, 165, 59, 0.1);
    }
    
    .search-btn {
        position: absolute;
        right: 6px;
        padding: 8px 24px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .search-btn:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-1px);
    }
    
    .active-filter {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: var(--gray-100);
        border-radius: 20px;
        font-size: 0.85rem;
        color: var(--gray-700);
    }
    
    .clear-filter {
        color: var(--gray-500);
        text-decoration: none;
        font-weight: bold;
        margin-left: 4px;
    }
    
    .clear-filter:hover {
        color: var(--danger);
    }
    
    /* Store Cards */
    .store-card {
        height: 100%;
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
    }
    
    .store-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.12);
        border-color: var(--brand-gold);
    }
    
    .store-card-inner {
        padding: 1.5rem;
        text-align: center;
    }
    
    .store-logo {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.25rem;
    }
    
    .store-logo img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--brand-gold);
        transition: transform 0.3s ease;
    }
    
    .store-card:hover .store-logo img {
        transform: scale(1.05);
    }
    
    .store-logo-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid var(--brand-gold);
    }
    
    .store-logo-placeholder i {
        font-size: 2.5rem;
        color: var(--brand-gold);
    }
    
    .store-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--brand-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .store-description {
        font-size: 0.85rem;
        color: var(--gray-600);
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .store-stats {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding: 0.75rem 0;
        border-top: 1px solid var(--gray-200);
        border-bottom: 1px solid var(--gray-200);
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--gray-600);
    }
    
    .stat-item i {
        color: var(--brand-gold);
        font-size: 0.9rem;
    }
    
    .btn-visit-store {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 10px 20px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-visit-store:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
        color: var(--brand-dark);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border-radius: 24px;
        border: 1px solid var(--gray-200);
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .empty-state-icon i {
        font-size: 2.5rem;
        color: var(--brand-gold);
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--gray-600);
        margin-bottom: 1.5rem;
    }
    
    .btn-clear-search {
        display: inline-flex;
        align-items: center;
        padding: 10px 24px;
        background: transparent;
        border: 1px solid var(--brand-gold);
        color: var(--brand-gold);
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-clear-search:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .search-wrapper {
            flex-direction: column;
            gap: 12px;
        }
        
        .search-icon {
            display: none;
        }
        
        .search-input {
            padding: 12px 16px;
        }
        
        .search-btn {
            position: static;
            width: 100%;
        }
        
        .store-stats {
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        
        .store-name {
            font-size: 1.1rem;
        }
    }
</style>
@endpush
@endsection