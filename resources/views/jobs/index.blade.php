@extends('layouts.app')

@section('title', 'Browse Jobs - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="position-relative d-inline-block">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--oweru-dark);">
                    Browse <span style="color: var(--oweru-gold); position: relative;">Jobs</span>
                </h1>
                <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: var(--oweru-gold); border-radius: 3px;"></div>
            </div>
            <p class="lead mt-4" style="color: var(--gray-600); max-width: 600px; margin: 0 auto;">
                Discover opportunities that match your skills and experience
            </p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-number">{{ $jobs->total() }}</div>
                <div class="stat-label">Available Jobs</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ number_format($jobs->total() * 3.5) }}+</div>
                <div class="stat-label">Active Professionals</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-number">{{ number_format($jobs->total() * 1.2) }}+</div>
                <div class="stat-label">Verified Clients</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="search-card">
                <form action="{{ route('jobs.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group-custom">
                                <i class="fas fa-search"></i>
                                <input type="text" name="keyword" class="form-control-custom" 
                                       placeholder="Job title or keywords..." value="{{ request('keyword') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group-custom">
                                <i class="fas fa-tag"></i>
                                <select name="category" class="form-select-custom">
                                    <option value="">All Categories</option>
                                    <option value="Engineer" {{ request('category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                    <option value="Architect" {{ request('category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                    <option value="Designer" {{ request('category') == 'Designer' ? 'selected' : '' }}>Designer</option>
                                    <option value="Electrician" {{ request('category') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                    <option value="Plumber" {{ request('category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                    <option value="Carpenter" {{ request('category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group-custom">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="location" class="form-control-custom" 
                                       placeholder="City or region..." value="{{ request('location') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn-search">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </div>
                </form>
                
                @if(request()->anyFilled(['keyword', 'category', 'location']))
                    <div class="active-filters mt-3">
                        <span class="filter-label">Active Filters:</span>
                        @if(request('keyword'))
                            <span class="filter-badge">
                                Keyword: {{ request('keyword') }}
                                <a href="{{ request()->fullUrlWithQuery(['keyword' => null]) }}">×</a>
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="filter-badge">
                                Category: {{ request('category') }}
                                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}">×</a>
                            </span>
                        @endif
                        @if(request('location'))
                            <span class="filter-badge">
                                Location: {{ request('location') }}
                                <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}">×</a>
                            </span>
                        @endif
                        <a href="{{ route('jobs.index') }}" class="clear-filters">Clear All</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Jobs Grid -->
    <div class="row">
        @forelse($jobs as $job)
        <div class="col-md-4 mb-4">
            <div class="job-card">
                <!-- Featured Badge -->
                @if($loop->index < 2)
                    <div class="featured-badge">
                        <i class="fas fa-star"></i> Featured
                    </div>
                @endif
                
                <!-- Category Badge -->
                <div class="category-badge">
                    {{ $job->service_category }}
                </div>
                
                <!-- Job Title -->
                <h3 class="job-title">{{ Str::limit($job->title, 40) }}</h3>
                
                <!-- Client Info -->
                <div class="client-info">
                    <img src="{{ $job->client->profile_image_url ?? 'https://via.placeholder.com/32x32/0F172A/F8F8F9?text=' . substr($job->client->name ?? 'U', 0, 1) }}" 
                         alt="{{ $job->client->name }}" class="client-avatar">
                    <span>{{ $job->client->name }}</span>
                </div>
                
                <!-- Location -->
                <div class="job-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $job->location ?? 'Remote' }}
                </div>
                
                <!-- Description -->
                <p class="job-description">{{ Str::limit($job->description, 100) }}</p>
                
                <!-- Budget -->
                <div class="job-budget">
                    <i class="fas fa-dollar-sign"></i>
                    ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                </div>
                
                <!-- Skills -->
                @if(!empty($job->required_skills) && is_array($job->required_skills))
                    <div class="skills-section">
                        @foreach(array_slice($job->required_skills, 0, 3) as $skill)
                            <span class="skill-tag">{{ trim($skill) }}</span>
                        @endforeach
                        @if(count($job->required_skills) > 3)
                            <span class="skill-tag">+{{ count($job->required_skills) - 3 }}</span>
                        @endif
                    </div>
                @endif
                
                <!-- Footer -->
                <div class="job-footer">
                    <div class="job-date">
                        <i class="far fa-clock"></i>
                        {{ $job->created_at->diffForHumans() }}
                    </div>
                    <a href="{{ route('jobs.show', $job) }}" class="btn-view">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>No Jobs Found</h3>
                <p>Try adjusting your search filters or check back later for new opportunities.</p>
                @auth
                    @if(Auth::user()->user_type == 'client')
                        <a href="{{ route('jobs.create') }}" class="btn-empty-action">
                            <i class="fas fa-plus-circle me-2"></i>Post a Job
                        </a>
                    @endif
                @endauth
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12">
            {{ $jobs->withQueryString()->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Stats Cards */
    .stat-card {
        background: var(--white);
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px -12px rgba(0,0,0,0.1);
        border-color: var(--oweru-gold);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .stat-icon i {
        font-size: 1.8rem;
        color: var(--oweru-gold);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--oweru-dark);
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--gray-600);
        font-weight: 500;
    }
    
    /* Search Card */
    .search-card {
        background: var(--white);
        border-radius: 24px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid var(--gray-200);
    }
    
    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .input-group-custom i {
        position: absolute;
        left: 16px;
        color: var(--gray-500);
        font-size: 1rem;
        pointer-events: none;
        z-index: 1;
    }
    
    .form-control-custom, .form-select-custom {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1px solid var(--gray-300);
        border-radius: 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
        background: var(--white);
    }
    
    .form-control-custom:focus, .form-select-custom:focus {
        outline: none;
        border-color: var(--oweru-gold);
        box-shadow: 0 0 0 3px rgba(201, 165, 59, 0.1);
    }
    
    .btn-search {
        width: 100%;
        padding: 12px;
        background: var(--oweru-gold);
        color: var(--oweru-dark);
        border: none;
        border-radius: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-search:hover {
        background: var(--oweru-gold-dark);
        transform: translateY(-2px);
    }
    
    /* Active Filters */
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid var(--gray-200);
    }
    
    .filter-label {
        font-size: 0.85rem;
        color: var(--gray-600);
        font-weight: 500;
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: var(--gray-100);
        border-radius: 20px;
        font-size: 0.8rem;
        color: var(--gray-700);
    }
    
    .filter-badge a {
        color: var(--gray-500);
        text-decoration: none;
        font-weight: bold;
        margin-left: 4px;
    }
    
    .filter-badge a:hover {
        color: var(--danger);
    }
    
    .clear-filters {
        font-size: 0.8rem;
        color: var(--oweru-gold);
        text-decoration: none;
        font-weight: 500;
    }
    
    /* Job Cards */
    .job-card {
        background: var(--white);
        border-radius: 20px;
        padding: 1.5rem;
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
        border-color: var(--oweru-gold);
    }
    
    .featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--oweru-gold) 0%, var(--oweru-gold-dark) 100%);
        color: var(--oweru-dark);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .category-badge {
        display: inline-block;
        padding: 5px 12px;
        background: rgba(201, 165, 59, 0.1);
        color: var(--oweru-gold);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .job-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--oweru-dark);
        margin-bottom: 1rem;
        line-height: 1.4;
    }
    
    .client-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 0.75rem;
    }
    
    .client-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--oweru-gold);
    }
    
    .client-info span {
        font-size: 0.85rem;
        color: var(--gray-700);
        font-weight: 500;
    }
    
    .job-location {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: var(--gray-600);
        margin-bottom: 0.75rem;
    }
    
    .job-location i {
        color: var(--oweru-gold);
        width: 16px;
    }
    
    .job-description {
        font-size: 0.85rem;
        color: var(--gray-600);
        line-height: 1.5;
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    
    .job-budget {
        font-size: 1rem;
        font-weight: 700;
        color: var(--oweru-gold);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .job-budget i {
        font-size: 0.9rem;
    }
    
    .skills-section {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 1rem;
    }
    
    .skill-tag {
        padding: 4px 10px;
        background: var(--gray-100);
        color: var(--gray-700);
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .job-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
        margin-top: auto;
    }
    
    .job-date {
        font-size: 0.75rem;
        color: var(--gray-500);
    }
    
    .job-date i {
        margin-right: 4px;
    }
    
    .btn-view {
        padding: 8px 16px;
        background: transparent;
        color: var(--oweru-gold);
        border: 1px solid var(--oweru-gold);
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-view:hover {
        background: var(--oweru-gold);
        color: var(--oweru-dark);
        transform: translateX(3px);
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
        color: var(--oweru-gold);
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--oweru-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--gray-600);
        margin-bottom: 1.5rem;
    }
    
    .btn-empty-action {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px;
        background: var(--oweru-gold);
        color: var(--oweru-dark);
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-empty-action:hover {
        background: var(--oweru-gold-dark);
        transform: translateY(-2px);
    }
</style>
@endpush
@endsection