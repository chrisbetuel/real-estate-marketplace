@extends('layouts.app')

@section('title', 'Professionals Directory')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5 fw-bold mb-3">Find Top <span class="text-warning">Professionals</span></h1>
            <p class="lead text-muted mb-4">Browse verified real estate experts. Login to unlock contact & messaging</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="row mb-5">
        <div class="col-12">
            <form method="GET" class="bg-white rounded-4 shadow-sm p-4">
                <div class="row align-items-end g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold small text-muted mb-2">Search professionals</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control border-0 ps-0" 
                                   placeholder="Name, skills, location..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted mb-2">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="Engineer" {{ request('category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                            <option value="Architect" {{ request('category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                            <option value="Electrician" {{ request('category') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                            <option value="Plumber" {{ request('category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                            <option value="Carpenter" {{ request('category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-muted mb-2 d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Find Professionals
                        </button>
                    </div>
                    @if(request('search') || request('category'))
                        <div class="col-md-2">
                            <label class="form-label fw-semibold small text-muted mb-2 d-none d-md-block">&nbsp;</label>
                            <a href="{{ route('professionals.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Results info -->
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong>{{ $professionals->total() }}</strong> professionals found
                    @if(request('category'))
                        in <strong>{{ request('category') }}</strong> category
                    @endif
                </div>
                <div class="text-muted small">
                    Showing {{ $professionals->firstItem() ?? 0 }} - {{ $professionals->lastItem() ?? 0 }} of {{ $professionals->total() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Professionals Grid -->
    <div class="row g-4">
        @forelse($professionals as $professional)
            <div class="col-lg-4 col-md-6">
                @include('professionals._card', ['professional' => $professional])
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-4"></i>
                <h3>No professionals found</h3>
                <p class="text-muted">Try adjusting your search or browse all professionals</p>
                <a href="{{ route('professionals.index') }}" class="btn btn-outline-primary">Browse All</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12">
            {{ $professionals->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Admin CTA -->
    @auth
        @if(auth()->user()->user_type === 'admin')
            <div class="row mt-5">
                <div class="col text-center">
                    <a href="{{ route('professionals.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Add New Professional
                    </a>
                </div>
            </div>
        @endif
    @endauth
</div>

@push('styles')
<style>
:root {
    --card-hover-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.professional-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.professional-card:hover:not(.locked-overlay) {
    transform: translateY(-4px);
    box-shadow: var(--card-hover-shadow);
}

@media (max-width: 768px) {
    .professional-card .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection
