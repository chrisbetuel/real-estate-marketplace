@extends('layouts.app')

@section('title', 'Browse Jobs - BuildConnect')

@section('content')
<div class="browse-jobs-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>Browse <span>Jobs</span></h1>
            <p>Find opportunities that match your skills</p>
        </div>

        

        <!-- Search Filters -->
        <div class="filters-card">
            <form action="{{ route('jobs.index') }}" method="GET" id="searchForm">
                <div class="filters-grid">
                    <div class="filter-input">
                        <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="keyword" class="input-field" placeholder="Job title or keywords" value="{{ request('keyword') }}">
                    </div>
                    <div class="filter-input">
                        <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20.59 13.41l-1.41 1.41a2 2 0 0 1-2.82 0L12 10.24a2 2 0 0 1 0-2.82l1.41-1.41"/>
                            <path d="M8 7L4 3M21 16l-4 4"/>
                            <path d="M16 21l-4-4 4-4 4 4-4 4z"/>
                        </svg>
                        <select name="category" class="input-field">
                            <option value="">All categories</option>
                            <option value="Architect" {{ request('category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                            <option value="Engineer" {{ request('category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                            <option value="Electrician" {{ request('category') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                            <option value="Plumber" {{ request('category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                            <option value="Carpenter" {{ request('category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                            <option value="Painter" {{ request('category') == 'Painter' ? 'selected' : '' }}>Painter</option>
                        </select>
                    </div>
                    <div class="filter-input">
                        <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <input type="text" name="location" class="input-field" placeholder="City or remote" value="{{ request('location') }}">
                    </div>
                    <button type="submit" class="search-btn">Search</button>
                </div>
            </form>
            
            @if(request()->anyFilled(['keyword', 'category', 'location']))
                <div class="active-filters">
                    @if(request('keyword'))
                        <span class="filter-tag">Keyword: {{ request('keyword') }} <a href="{{ request()->fullUrlWithQuery(['keyword' => null]) }}">×</a></span>
                    @endif
                    @if(request('category'))
                        <span class="filter-tag">{{ request('category') }} <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}">×</a></span>
                    @endif
                    @if(request('location'))
                        <span class="filter-tag">{{ request('location') }} <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}">×</a></span>
                    @endif
                    <a href="{{ route('jobs.index') }}" class="clear-filters">Clear all</a>
                </div>
            @endif
        </div>

        <!-- Results Header -->
        <div class="results-header">
            <div class="results-count">
                Showing {{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
            </div>
            <div class="sort-wrapper">
                <span class="sort-label">Sort by:</span>
                <form action="{{ route('jobs.index') }}" method="GET" id="sortForm" style="display: inline;">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="budget_high" {{ request('sort') == 'budget_high' ? 'selected' : '' }}>Highest budget</option>
                        <option value="budget_low" {{ request('sort') == 'budget_low' ? 'selected' : '' }}>Lowest budget</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Jobs List -->
        <div class="jobs-list">
            @forelse($jobs as $job)
                <div class="job-item">
                    <div class="job-left">
                        <div class="job-category">{{ $job->service_category ?? 'General' }}</div>
                        <h3 class="job-title"><a href="{{ route('jobs.show', $job) }}">{{ Str::limit($job->title, 50) }}</a></h3>
                        <div class="job-meta">
                            <span class="meta-location">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $job->location ?? 'Remote' }}
                            </span>
                            <span class="meta-date">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $job->created_at->diffForHumans() }}
                            </span>
                            <span class="meta-bids">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20 12V8H4v12h12"/>
                                    <path d="M12 2v4"/>
                                </svg>
                                {{ $job->bids_count ?? 0 }} bids
                            </span>
                        </div>
                        <p class="job-description">{{ Str::limit($job->description, 120) }}</p>
                        @if(!empty($job->required_skills))
                            <div class="job-skills">
                                @foreach(array_slice($job->required_skills, 0, 4) as $skill)
                                    @if(trim($skill))
                                        <span class="skill-badge">{{ trim($skill) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="job-right">
                        <div class="job-budget">${{ number_format($job->budget_min) }}–${{ number_format($job->budget_max) }}</div>
                        <a href="{{ route('jobs.show', $job) }}" class="job-btn">View details →</a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    <h3>No jobs found</h3>
                    <p>Try adjusting your search filters</p>
                    @auth
                        @if(Auth::user()->user_type == 'client')
                            <a href="{{ route('jobs.create') }}" class="empty-btn">Post a job</a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($jobs->hasPages())
            <div class="pagination-wrapper">
                {{ $jobs->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.browse-jobs-page {
    background: #F4F6F9;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 28px;
}

.page-header h1 {
    font-size: 28px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 6px 0;
}

.page-header h1 span {
    color: #C6A43B;
}

.page-header p {
    font-size: 14px;
    color: #6B7A8F;
    margin: 0;
}

.stats-row {
    display: flex;
    justify-content: center;
    gap: 48px;
    margin-bottom: 32px;
    padding: 8px 0;
}

.stat-item {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 24px;
    font-weight: 700;
    color: #1A2C3E;
}

.stat-label {
    font-size: 12px;
    color: #8A99B0;
}

.filters-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
    border: 1px solid #E2E8F0;
}

.filters-grid {
    display: flex;
    gap: 12px;
    align-items: flex-end;
}

.filter-input {
    flex: 1;
    position: relative;
}

.input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    pointer-events: none;
}

.input-field {
    width: 100%;
    padding: 10px 12px 10px 36px;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    background: white;
    transition: all 0.2s;
}

.input-field:focus {
    outline: none;
    border-color: #C6A43B;
    box-shadow: 0 0 0 2px rgba(198,164,59,0.08);
}

.search-btn {
    padding: 10px 24px;
    background: #1A2C3E;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.search-btn:hover {
    background: #2A3E52;
}

.active-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #F0F2F5;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: #F0F2F5;
    border-radius: 20px;
    font-size: 12px;
    color: #4A5A72;
}

.filter-tag a {
    color: #8A99B0;
    text-decoration: none;
    font-weight: 600;
}

.filter-tag a:hover {
    color: #DC2626;
}

.clear-filters {
    font-size: 12px;
    color: #C6A43B;
    text-decoration: none;
}

.clear-filters:hover {
    text-decoration: underline;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.results-count {
    font-size: 13px;
    color: #6B7A8F;
}

.sort-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.sort-label {
    font-size: 12px;
    color: #8A99B0;
}

.sort-select {
    padding: 6px 28px 6px 12px;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 12px;
    background: white;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A99B0' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
}

.jobs-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 32px;
}

.job-item {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.job-item:hover {
    border-color: #C6A43B;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.job-left {
    flex: 1;
}

.job-category {
    display: inline-block;
    padding: 2px 8px;
    background: #F0F2F5;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 500;
    color: #5A6E85;
    margin-bottom: 8px;
}

.job-title {
    margin: 0 0 8px 0;
}

.job-title a {
    font-size: 16px;
    font-weight: 600;
    color: #1A2C3E;
    text-decoration: none;
}

.job-title a:hover {
    color: #C6A43B;
}

.job-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 10px;
}

.meta-location, .meta-date, .meta-bids {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: #8A99B0;
}

.meta-location svg, .meta-date svg, .meta-bids svg {
    stroke: #B0C0D0;
}

.job-description {
    font-size: 12px;
    color: #5A6E85;
    line-height: 1.5;
    margin-bottom: 10px;
}

.job-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.skill-badge {
    padding: 2px 8px;
    background: #F4F6F9;
    border-radius: 4px;
    font-size: 10px;
    color: #6B7A8F;
}

.job-right {
    text-align: right;
    margin-left: 20px;
    min-width: 120px;
}

.job-budget {
    font-size: 16px;
    font-weight: 700;
    color: #1A2C3E;
    margin-bottom: 8px;
}

.job-btn {
    display: inline-block;
    padding: 6px 16px;
    background: transparent;
    border: 1px solid #C6A43B;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #C6A43B;
    text-decoration: none;
    transition: all 0.2s;
}

.job-btn:hover {
    background: #C6A43B;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 48px 20px;
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.empty-state svg {
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 16px;
    font-weight: 500;
    color: #1A2C3E;
    margin: 0 0 4px 0;
}

.empty-state p {
    font-size: 13px;
    color: #8A99B0;
    margin-bottom: 16px;
}

.empty-btn {
    display: inline-block;
    padding: 8px 20px;
    background: #1A2C3E;
    color: white;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
}

.empty-btn:hover {
    background: #2A3E52;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination-wrapper .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    color: #4A5A72;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.2s;
}

.pagination-wrapper .page-item.active .page-link {
    background: #1A2C3E;
    border-color: #1A2C3E;
    color: white;
}

.pagination-wrapper .page-item .page-link:hover {
    border-color: #C6A43B;
    color: #C6A43B;
}

@media (max-width: 768px) {
    .filters-grid {
        flex-direction: column;
    }
    
    .search-btn {
        width: 100%;
    }
    
    .job-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .job-right {
        text-align: left;
        margin-left: 0;
        margin-top: 12px;
        width: 100%;
    }
    
    .stats-row {
        gap: 24px;
    }
    
    .results-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .page-header h1 {
        font-size: 24px;
    }
    
    .stats-row {
        gap: 16px;
    }
    
    .stat-value {
        font-size: 20px;
    }
}
</style>
@endpush