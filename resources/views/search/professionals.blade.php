@extends('layouts.app')

@section('title', 'Search Professionals - BuildConnect')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="position-relative d-inline-block">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--brand-dark);">
                    Find <span style="color: var(--brand-gold);">Professionals</span>
                </h1>
                <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: var(--brand-gold); border-radius: 3px;"></div>
            </div>
            <p class="lead mt-4" style="color: var(--gray-600); max-width: 600px; margin: 0 auto;">
                @if(request('category'))
                    Top {{ ucfirst(request('category')) }} professionals
                @else
                    Connect with top-rated professionals for your real estate projects
                @endif
            </p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="search-card">
                <form method="GET" action="{{ route('search.professionals') }}">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium mb-2">Search</label>
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" name="search" class="search-input" 
                                       placeholder="Name, profession, expertise..." 
                                       value="{{ request('search') ?? request('keyword') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium mb-2">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="Engineer" {{ request('category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                <option value="Architect" {{ request('category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                <option value="Electrician" {{ request('category') == 'Electrician' : '' }}>Electrician</option>
                                <option value="Plumber" {{ request('category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                <option value="Carpenter" {{ request('category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium mb-2">Location</label>
                            <input type="text" name="location" class="form-control" 
                                   placeholder="City or state" value="{{ request('location') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100 search-btn">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Active Filters -->
                @if(request()->anyFilled(['search', 'category', 'location', 'keyword']))
                    <div class="active-filters mt-4 pt-3 border-top">
                        @if(request('search') || request('keyword'))
                            <span class="filter-badge">
                                Search: "{{ request('search') ?? request('keyword') }}"
                                <a href="{{ request()->fullUrlWithQuery([request('search') ? 'search' : 'keyword' => null]) }}" class="clear-filter">×</a>
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="filter-badge">
                                Category: {{ request('category') }}
                                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="clear-filter">×</a>
                            </span>
                        @endif
                        @if(request('location'))
                            <span class="filter-badge">
                                Location: {{ request('location') }}
                                <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}" class="clear-filter">×</a>
                            </span>
                        @endif
                        <a href="{{ route('search.professionals') }}" class="btn-clear-all">
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Results Count -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $professionals->total() }} </strong>
                    @if(request('category'))
                        {{ ucfirst(request('category')) }} professionals found
                    @else
                        professionals found
                    @endif
                </div>
                <div class="text-muted small">
                    Showing {{ $professionals->firstItem() }}-{{ $professionals->lastItem() }} of {{ $professionals->total() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Professionals Grid -->
    <div class="row">
@forelse($professionals as $professional)
            @include('professionals._card', ['professional' => $professional])
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <div class="empty-state-icon">
                        <i class="fas fa-users-slash" style="font-size: 4rem; color: var(--gray-400);"></i>
                    </div>
                    <h3 class="mt-3 mb-2">No Professionals Found</h3>
                    <p class="text-muted mb-4">
                        We couldn't find any professionals matching your criteria. 
                        @if(request('category'))
                            Try a different {{ ucfirst(request('category')) }} search or <a href="{{ route('search.professionals') }}">clear filters</a>.
                        @endif
                    </p>
                    <a href="{{ route('professionals.index') }}" class="btn btn-outline-primary">
                        Browse All Professionals
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12">
            {{ $professionals->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .active-filters {
        border-top: 1px solid var(--gray-200);
        padding-top: 1.5rem;
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: var(--gray-100);
        color: var(--gray-700);
        border-radius: 20px;
        font-size: 0.85rem;
        margin-right: 10px;
        margin-bottom: 8px;
    }
    
    .clear-filter {
        color: var(--gray-500);
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1rem;
        line-height: 1;
    }
    
    .clear-filter:hover {
        color: var(--danger);
    }
    
    .btn-clear-all {
        font-size: 0.85rem;
        color: var(--gray-600);
        text-decoration: underline;
    }
    
    .btn-clear-all:hover {
        color: var(--brand-gold);
    }
    
    /* Include professional card styles from professional/index.blade.php */
    .professional-card {
        /* ... same styles as professional/index.blade.php ... */
    }
    /* Copy all professional-card related styles here */
</style>
@endpush


@endsection
