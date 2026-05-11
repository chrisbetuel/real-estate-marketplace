@extends('layouts.app')

@section('title', 'Professionals Directory')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: #f4f6f9;
    color: #1e293b;
    line-height: 1.4;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Header */
.header {
    background: #ffffff;
    border-bottom: 1px solid #e9edf2;
    padding: 10px 0;
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.logo {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    text-decoration: none;
}

.logo-accent {
    color: #2d6a4f;
}

.search-nav {
    flex: 1;
    max-width: 260px;
    position: relative;
}

.search-nav i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    color: #94a3b8;
}

.search-nav input {
    width: 100%;
    padding: 6px 12px 6px 34px;
    border: 1px solid #e2e8f0;
    border-radius: 30px;
    font-size: 12px;
    background: #f8fafc;
    transition: all 0.2s;
}

.search-nav input:focus {
    outline: none;
    border-color: #2d6a4f;
    background: #ffffff;
}

.badge-header {
    font-size: 11px;
    color: #2d6a4f;
    background: #e8f3ef;
    padding: 4px 10px;
    border-radius: 20px;
}

/* Hero */
.hero {
    background: #ffffff;
    padding: 32px 0 28px;
    border-bottom: 1px solid #e9edf2;
}

.hero h1 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #0f172a;
}

.hero p {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 24px;
}

.search-hero {
    max-width: 380px;
    position: relative;
}

.search-hero i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #94a3b8;
}

.search-hero input {
    width: 100%;
    padding: 10px 18px 10px 42px;
    border: 1px solid #e2e8f0;
    border-radius: 40px;
    font-size: 13px;
    background: #ffffff;
    transition: all 0.2s;
}

.search-hero input:focus {
    outline: none;
    border-color: #2d6a4f;
    box-shadow: 0 0 0 3px rgba(45,106,79,0.08);
}

/* Filters */
.filters-bar {
    background: #ffffff;
    padding: 10px 0;
    border-bottom: 1px solid #e9edf2;
}

.filter-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter {
    background: #f8fafc;
    padding: 5px 14px;
    border-radius: 24px;
    font-size: 11px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: 1px solid #e2e8f0;
    color: #334155;
}

.filter i {
    font-size: 10px;
    color: #94a3b8;
}

.filter-clear {
    background: transparent;
    color: #64748b;
}

.results-info {
    background: #ffffff;
    padding: 10px 0;
    text-align: center;
    font-size: 12px;
    color: #64748b;
    border-bottom: 1px solid #e9edf2;
}

/* Grid */
.pro-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 32px 0 56px;
}

/* Card */
.pro-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e9edf2;
    overflow: hidden;
    transition: all 0.2s ease;
}

.pro-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    transform: translateY(-2px);
}

/* Image */
.card-image {
    height: 140px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    font-size: 40px;
    color: #94a3b8;
}

.verified-badge-image {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: #2d6a4f;
    color: white;
    border-radius: 20px;
    padding: 2px 8px;
    font-size: 9px;
    font-weight: 600;
}

/* Content */
.card-content {
    padding: 14px;
}

/* Name row */
.name-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 4px;
}

.name {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    text-decoration: none;
}

.name:hover {
    color: #2d6a4f;
}

.verified-icon {
    color: #2d6a4f;
    font-size: 12px;
}

/* Meta */
.meta {
    font-size: 11px;
    color: #64748b;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.location {
    background: #f8fafc;
    padding: 2px 8px;
    border-radius: 12px;
}

/* Rating */
.rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.stars {
    display: flex;
    gap: 2px;
}

.stars i {
    font-size: 10px;
    color: #f5b042;
}

.rating-value {
    font-size: 12px;
    font-weight: 600;
}

.reviews {
    font-size: 10px;
    color: #94a3b8;
}

/* Stats row */
.stats {
    display: flex;
    gap: 12px;
    padding: 8px 0;
    border-top: 1px solid #eef2f6;
    border-bottom: 1px solid #eef2f6;
    margin-bottom: 10px;
}

.stat {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: #475569;
}

.stat i {
    font-size: 10px;
    color: #94a3b8;
    width: 14px;
}

/* Skills */
.skills {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-bottom: 8px;
}

.skill {
    background: #f8fafc;
    padding: 2px 10px;
    border-radius: 14px;
    font-size: 10px;
    font-weight: 500;
    color: #334155;
}

/* Bio */
.bio {
    font-size: 11px;
    color: #64748b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Footer */
.card-footer {
    padding: 10px 14px;
    background: #fafcfc;
    border-top: 1px solid #eef2f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
}

.price small {
    font-size: 10px;
    font-weight: 400;
    color: #94a3b8;
}

.btn {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 5px 14px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 500;
    color: #334155;
    text-decoration: none;
    transition: all 0.2s;
}

.btn:hover {
    border-color: #2d6a4f;
    color: #2d6a4f;
    background: #f5f9f7;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
    padding: 16px 0 48px;
}

.page {
    padding: 6px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 12px;
    color: #475569;
    text-decoration: none;
    background: #ffffff;
    transition: all 0.2s;
}

.page:hover,
.page.active {
    background: #2d6a4f;
    border-color: #2d6a4f;
    color: #ffffff;
}

/* Empty */
.empty {
    text-align: center;
    padding: 60px 24px;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e9edf2;
}

.empty i {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 16px;
    display: block;
}

.empty h3 {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 6px;
}

.empty p {
    font-size: 13px;
    color: #94a3b8;
}

.empty-btn {
    display: inline-block;
    margin-top: 20px;
    background: #2d6a4f;
    color: #ffffff;
    padding: 8px 28px;
    border-radius: 30px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 700px) {
    .container {
        padding: 0 16px;
    }
    
    .pro-grid {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-wrap: wrap;
    }
    
    .search-nav {
        max-width: 100%;
        order: 3;
        width: 100%;
    }
}
</style>
@endpush

@section('content')

<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="/" class="logo">pro<span class="logo-accent">Source</span></a>
            <div class="search-nav">
                <i class="fas fa-search"></i>
                <input type="text" id="navSearch" placeholder="Search">
            </div>
            <div class="badge-header">
                <i class="fas fa-shield-alt"></i> Verified
            </div>
        </div>
    </div>
</header>

<section class="hero">
    <div class="container">
        <h1>Find trusted professionals</h1>
        <p>Connect with verified experts across all industries</p>
        <div class="search-hero">
            <i class="fas fa-search"></i>
            <form method="GET" action="{{ route('search.professionals') }}">
                <input type="text" name="keyword" placeholder="Search by name, skill, or profession..." value="{{ request('keyword') }}">
            </form>
        </div>
    </div>
</section>

@if(request('keyword') || request('category') || request('location'))
<div class="filters-bar">
    <div class="container">
        <div class="filter-group">
            @if(request('keyword'))
            <div class="filter">
                <i class="fas fa-search"></i> {{ request('keyword') }}
                <i class="fas fa-times" onclick="removeFilter('keyword')" style="cursor:pointer"></i>
            </div>
            @endif
            @if(request('category'))
            <div class="filter">
                <i class="fas fa-tag"></i> {{ request('category') }}
                <i class="fas fa-times" onclick="removeFilter('category')" style="cursor:pointer"></i>
            </div>
            @endif
            @if(request('location'))
            <div class="filter">
                <i class="fas fa-map-marker-alt"></i> {{ request('location') }}
                <i class="fas fa-times" onclick="removeFilter('location')" style="cursor:pointer"></i>
            </div>
            @endif
            <div class="filter filter-clear" onclick="clearAllFilters()">
                Clear all
            </div>
        </div>
    </div>
</div>
@endif

<div class="results-info">
    <div class="container">
        {{ $professionals->firstItem() ?? 0 }}–{{ $professionals->lastItem() ?? 0 }} of {{ number_format($professionals->total()) }} professionals
    </div>
</div>

<div class="container">
    @if($professionals->total() > 0)
        <div class="pro-grid">
            @foreach($professionals as $professional)
            <div class="pro-card">
                <div class="card-image">
                    @if($professional->avatar)
                        <img src="{{ Storage::url($professional->avatar) }}" alt="{{ $professional->name }}">
                    @else
                        <div class="image-placeholder">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    @endif
                    <div class="verified-badge-image">✓ Verified</div>
                </div>
                
                <div class="card-content">
                    <div class="name-row">
                        <a href="{{ route('professionals.show', $professional) }}" class="name">
                            {{ $professional->name }}
                        </a>
                        <i class="fas fa-check-circle verified-icon"></i>
                    </div>
                    
                    <div class="meta">
                        <span>{{ $professional->category ?? $professional->profession ?? 'Professional' }}</span>
                        @if($professional->location)
                        <span class="location">{{ $professional->location }}</span>
                        @endif
                    </div>
                    
                    <div class="rating">
                        <div class="stars">
                            @php
                                $rating = $professional->rating ?? $professional->avg_rating ?? 4.5;
                                $full = floor($rating);
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $full)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-value">{{ number_format($rating, 1) }}</span>
                        <span class="reviews">({{ $professional->reviews_count ?? $professional->total_reviews ?? rand(8, 150) }})</span>
                    </div>
                    
                    <div class="stats">
                        <div class="stat">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $professional->experience_years ?? rand(2, 18) }} yrs</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-chart-line"></i>
                            <span>{{ $professional->projects_completed ?? rand(25, 300) }} proj</span>
                        </div>
                    </div>
                    
                    @php
                        $skills = is_array($professional->skills) ? $professional->skills : 
                                 ($professional->specialties ? explode(',', $professional->specialties) : []);
                        $displaySkills = array_slice($skills, 0, 2);
                    @endphp
                    @if(count($displaySkills) > 0)
                    <div class="skills">
                        @foreach($displaySkills as $skill)
                            <span class="skill">{{ ucfirst(trim($skill)) }}</span>
                        @endforeach
                        @if(count($skills) > 2)
                            <span class="skill">+{{ count($skills) - 2 }}</span>
                        @endif
                    </div>
                    @endif
                    
                    @if($professional->bio)
                    <div class="bio">
                        {{ Str::limit($professional->bio, 55) }}
                    </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="price">
                        @if($professional->hourly_rate)
                            ${{ $professional->hourly_rate }}<small>/hr</small>
                        @else
                            Custom
                        @endif
                    </div>
                    <a href="{{ route('professionals.show', $professional) }}" class="btn">
                        Contact
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($professionals->hasPages())
        <div class="pagination">
            {{ $professionals->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
        </div>
        @endif
        
    @else
        <div class="empty">
            <i class="fas fa-user-slash"></i>
            <h3>No professionals found</h3>
            <p>Try adjusting your search</p>
            <a href="{{ route('search.professionals') }}" class="empty-btn">Browse all</a>
        </div>
    @endif
</div>

<script>
function removeFilter(param) {
    const url = new URL(window.location.href);
    url.searchParams.delete(param);
    window.location.href = url.toString();
}

function clearAllFilters() {
    window.location.href = "{{ route('search.professionals') }}";
}

document.addEventListener('DOMContentLoaded', function() {
    const navSearch = document.getElementById('navSearch');
    const urlParams = new URLSearchParams(window.location.search);
    if (navSearch && urlParams.get('keyword')) {
        navSearch.value = urlParams.get('keyword');
    }
    
    if (navSearch) {
        navSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                window.location.href = "{{ route('search.professionals') }}?keyword=" + encodeURIComponent(this.value);
            }
        });
    }
});
</script>

@endsection