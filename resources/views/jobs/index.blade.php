@extends('layouts.app')

@section('title', 'Browse Jobs - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1>Browse <span>Jobs</span></h1>
                <p>Discover opportunities that match your skills and experience</p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div class="stat-number">{{ $jobs->total() }}</div>
                <div class="stat-label">Available Jobs</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="stat-number">{{ number_format($jobs->total() * 3.5) }}+</div>
                <div class="stat-label">Active Professionals</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div class="stat-number">{{ number_format($jobs->total() * 1.2) }}+</div>
                <div class="stat-label">Verified Clients</div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-card">
            <form action="{{ route('jobs.index') }}" method="GET" id="searchForm">
                <div class="search-grid">
                    <div class="search-field">
                        <div class="input-with-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            <input type="text" name="keyword" class="form-input" 
                                   placeholder="Job title or keywords..." value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="search-field">
                        <div class="input-with-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.59 13.41l-1.41 1.41a2 2 0 0 1-2.82 0L12 10.24a2 2 0 0 1 0-2.82l1.41-1.41"/>
                                <path d="M8 7L4 3M21 16l-4 4"/>
                                <path d="M16 21l-4-4 4-4 4 4-4 4z"/>
                            </svg>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="Engineer" {{ request('category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                <option value="Architect" {{ request('category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                <option value="Designer" {{ request('category') == 'Designer' ? 'selected' : '' }}>Designer</option>
                                <option value="Electrician" {{ request('category') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                <option value="Plumber" {{ request('category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                <option value="Carpenter" {{ request('category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                                <option value="Painter" {{ request('category') == 'Painter' ? 'selected' : '' }}>Painter</option>
                                <option value="Project Manager" {{ request('category') == 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
                                <option value="Quantity Surveyor" {{ request('category') == 'Quantity Surveyor' ? 'selected' : '' }}>Quantity Surveyor</option>
                            </select>
                        </div>
                    </div>
                    <div class="search-field">
                        <div class="input-with-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <input type="text" name="location" class="form-input" 
                                   placeholder="City or region..." value="{{ request('location') }}">
                        </div>
                    </div>
                    <div class="search-action">
                        <button type="submit" class="btn-search">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            Search Jobs
                        </button>
                    </div>
                </div>
            </form>
            
            @if(request()->anyFilled(['keyword', 'category', 'location']))
                <div class="active-filters">
                    <span class="filter-label">Active Filters:</span>
                    @if(request('keyword'))
                        <span class="filter-badge">
                            Keyword: {{ request('keyword') }}
                            <a href="{{ request()->fullUrlWithQuery(['keyword' => null]) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    @if(request('category'))
                        <span class="filter-badge">
                            Category: {{ request('category') }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    @if(request('location'))
                        <span class="filter-badge">
                            Location: {{ request('location') }}
                            <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    <a href="{{ route('jobs.index') }}" class="clear-filters">Clear All</a>
                </div>
            @endif
        </div>

        <!-- Results Header -->
        <div class="results-header">
            <div>
                <h3>Available Jobs</h3>
                <p>Showing {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs</p>
            </div>
            <div class="sort-options">
                <span class="sort-label">Sort by:</span>
                <form action="{{ route('jobs.index') }}" method="GET" id="sortForm" class="sort-form">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="budget_high" {{ request('sort') == 'budget_high' ? 'selected' : '' }}>Highest Budget</option>
                        <option value="budget_low" {{ request('sort') == 'budget_low' ? 'selected' : '' }}>Lowest Budget</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Jobs Grid -->
        <div class="jobs-grid">
            @forelse($jobs as $job)
                <div class="job-card">
                    @if($loop->index < 2)
                        <div class="featured-badge">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            Featured
                        </div>
                    @endif
                    
                    <div class="category-badge">{{ $job->service_category ?? 'General' }}</div>
                    
                    <h3 class="job-title">
                        <a href="{{ route('jobs.show', $job) }}">{{ Str::limit($job->title, 45) }}</a>
                    </h3>
                    
                    <div class="client-info">
                        <div class="client-avatar">
                            <img src="{{ $job->client->profile_image_url ?? 'https://ui-avatars.com/api/?background=2563EB&color=fff&name=' . urlencode(substr($job->client->name ?? 'C', 0, 1)) }}" 
                                 alt="{{ $job->client->name ?? 'Client' }}">
                        </div>
                        <span class="client-name">{{ $job->client->name ?? 'Anonymous Client' }}</span>
                        @if($job->client->is_verified ?? false)
                            <span class="verified-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                    
                    <div class="job-location">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $job->location ?? 'Remote' }}
                    </div>
                    
                    <p class="job-description">{{ Str::limit($job->description, 100) }}</p>
                    
                    <div class="job-budget">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                    </div>
                    
                    @if(!empty($job->required_skills) && is_array($job->required_skills))
                        <div class="skills-section">
                            @foreach(array_slice($job->required_skills, 0, 3) as $skill)
                                @if(trim($skill))
                                    <span class="skill-tag">{{ trim($skill) }}</span>
                                @endif
                            @endforeach
                            @if(count($job->required_skills) > 3)
                                <span class="skill-tag more">+{{ count($job->required_skills) - 3 }}</span>
                            @endif
                        </div>
                    @endif
                    
                    <div class="job-footer">
                        <div class="job-date">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            {{ $job->created_at->diffForHumans() }}
                        </div>
                        <div class="bids-count">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 12V8H4v12h12"/>
                                <path d="M12 2v4"/>
                            </svg>
                            {{ $job->bids_count ?? 0 }} bids
                        </div>
                        <a href="{{ route('jobs.show', $job) }}" class="btn-view">
                            View Details
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                    <h3>No Jobs Found</h3>
                    <p>Try adjusting your search filters or check back later for new opportunities.</p>
                    @auth
                        @if(Auth::user()->user_type == 'client')
                            <a href="{{ route('jobs.create') }}" class="btn-empty-action">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Post a Job
                            </a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($jobs->hasPages())
            <div class="pagination-container">
                {{ $jobs->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-container {
    background: #F1F5F9;
    min-height: calc(100vh - 64px);
    padding: 40px 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Typography */
h1, h2, h3, h4 {
    font-weight: 600;
    letter-spacing: -0.02em;
}

/* Hero Section */
.hero-section {
    text-align: center;
    margin-bottom: 48px;
}

.hero-content h1 {
    font-size: 32px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 12px 0;
}

.hero-content h1 span {
    color: gold;
    position: relative;
}

.hero-content p {
    font-size: 16px;
    color: #475569;
    max-width: 500px;
    margin: 0 auto;
}

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    transition: all 0.2s;
    border: 1px solid #E2E8F0;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -8px rgba(0,0,0,0.08);
    border-color: gold;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: #EFF6FF;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

.stat-icon svg {
    stroke: gold;
}

.stat-number {
    font-size: 28px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 13px;
    font-weight: 500;
    color: #64748B;
}

/* Search Card */
.search-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    border: 1px solid #E2E8F0;
}

.search-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: 16px;
    align-items: end;
}

.search-field {
    width: 100%;
}

.input-with-icon {
    position: relative;
}

.input-with-icon svg {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    stroke: #94A3B8;
    pointer-events: none;
}

.form-input, .form-select {
    width: 100%;
    padding: 12px 16px 12px 44px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    font-size: 14px;
    color: #1E293B;
    transition: all 0.2s;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: gold;
    background: white;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.form-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
}

.btn-search {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 24px;
    background: gold;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-search:hover {
    background: gold;
    transform: translateY(-1px);
}

/* Active Filters */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #F1F5F9;
}

.filter-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    background: #F1F5F9;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #1E293B;
}

.remove-filter {
    color: #94A3B8;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
}

.remove-filter:hover {
    color: #EF4444;
}

.clear-filters {
    font-size: 12px;
    font-weight: 500;
    color: gold;
    text-decoration: none;
}

.clear-filters:hover {
    color: gold;
    text-decoration: underline;
}

/* Results Header */
.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.results-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.results-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.sort-options {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sort-label {
    font-size: 13px;
    color: #64748B;
}

.sort-form {
    margin: 0;
}

.sort-select {
    padding: 8px 32px 8px 14px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #1E293B;
    cursor: pointer;
    transition: all 0.2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
}

.sort-select:hover {
    border-color: gold;
}

/* Jobs Grid */
.jobs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

/* Job Card */
.job-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    position: relative;
    transition: all 0.2s;
    border: 1px solid #E2E8F0;
    display: flex;
    flex-direction: column;
}

.job-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -8px rgba(0,0,0,0.1);
    border-color: #CBD5E1;
}

.featured-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 12px;
    background: #FEF3C7;
    color: #D97706;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.featured-badge svg {
    stroke: #D97706;
}

.category-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #EFF6FF;
    color: #2563EB;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 16px;
    width: fit-content;
}

.job-title {
    margin: 0 0 12px 0;
    font-size: 18px;
    font-weight: 600;
    line-height: 1.4;
}

.job-title a {
    color: #0F172A;
    text-decoration: none;
    transition: color 0.2s;
}

.job-title a:hover {
    color: gold;
}

/* Client Info */
.client-info {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}

.client-avatar img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.client-name {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    height: 16px;
    background: #10B981;
    border-radius: 50%;
}

.verified-badge svg {
    stroke: white;
    width: 10px;
    height: 10px;
}

/* Job Location */
.job-location {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748B;
    margin-bottom: 12px;
}

.job-location svg {
    stroke: #94A3B8;
}

/* Job Description */
.job-description {
    font-size: 13px;
    color: #475569;
    line-height: 1.5;
    margin-bottom: 16px;
    flex-grow: 1;
}

/* Job Budget */
.job-budget {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 12px;
}

.job-budget svg {
    stroke: gold;
}

/* Skills Section */
.skills-section {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.skill-tag {
    padding: 4px 10px;
    background: #F1F5F9;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
    color: #475569;
}

.skill-tag.more {
    background: #EFF6FF;
    color: #2563EB;
}

/* Job Footer */
.job-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
    margin-top: auto;
}

.job-date, .bids-count {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #94A3B8;
}

.job-date svg, .bids-count svg {
    stroke: #94A3B8;
}

.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: transparent;
    color: gold;
    border: 1px solid gold;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view:hover {
    background: gold;
    color: white;
    transform: translateX(2px);
}

.btn-view svg {
    stroke: currentColor;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
    background: white;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
}

.empty-icon {
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: #64748B;
    margin-bottom: 24px;
}

.btn-empty-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: gold;
    color: white;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-empty-action:hover {
    background: gold;
    transform: translateY(-2px);
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination-container .pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination-container .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 8px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    color: #1E293B;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.pagination-container .page-item.active .page-link {
    background: gold;
    border-color: gold;
    color: white;
}

.pagination-container .page-item .page-link:hover {
    border-color: gold;
    color: gold;
}

/* Responsive */
@media (max-width: 1024px) {
    .search-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .search-action {
        grid-column: span 2;
    }
    
    .jobs-grid {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 24px 0;
    }
    
    .container {
        padding: 0 16px;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .search-grid {
        grid-template-columns: 1fr;
    }
    
    .search-action {
        grid-column: span 1;
    }
    
    .results-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .jobs-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 28px;
    }
    
    .job-footer {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .btn-view {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush