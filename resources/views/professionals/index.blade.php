@extends('layouts.app')

@section('title', 'Professionals Directory - ' . (request('keyword') ? request('keyword') : 'Find Top Professionals'))

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* ============================================
   MODERN SEARCH RESULTS PAGE
   BEAUTIFUL, CLEAN, FOCUSED
   ============================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
    color: #1a1a1a;
    line-height: 1.5;
}

/* Container */
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 32px;
}

/* ============================================
   SEARCH HEADER - STUNNING
   ============================================ */
.search-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: white;
    padding: 60px 0 40px;
    position: relative;
    overflow: hidden;
}

.search-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.search-header .container {
    position: relative;
    z-index: 2;
}

.search-title {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 16px;
    background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.search-title span {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.search-subtitle {
    font-size: 18px;
    color: #cbd5e1;
    margin-bottom: 30px;
}

/* Search Form */
.search-form-wrapper {
    max-width: 800px;
    margin-top: 20px;
}

.search-form {
    display: flex;
    gap: 12px;
    background: white;
    padding: 8px;
    border-radius: 60px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.search-input {
    flex: 1;
    border: none;
    padding: 16px 24px;
    font-size: 16px;
    border-radius: 60px;
    outline: none;
    font-weight: 500;
}

.search-input::placeholder {
    color: #94a3b8;
}

.search-btn {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border: none;
    padding: 0 32px;
    border-radius: 60px;
    color: #0f172a;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(245,158,11,0.3);
}

/* Stats Badge */
.stats-badge {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    padding: 12px 24px;
    border-radius: 50px;
    margin-top: 30px;
    font-size: 14px;
    border: 1px solid rgba(255,255,255,0.2);
}

.stats-badge i {
    color: #fbbf24;
}

.stats-number {
    font-weight: 800;
    font-size: 24px;
    color: #fbbf24;
    margin-right: 4px;
}

/* ============================================
   FILTERS BAR
   ============================================ */
.filters-bar {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.filters-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    flex-wrap: wrap;
    gap: 16px;
}

.active-filters {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-chip {
    background: #f1f5f9;
    padding: 8px 16px;
    border-radius: 40px;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #334155;
    transition: all 0.2s;
}

.filter-chip i {
    cursor: pointer;
    color: #94a3b8;
    transition: color 0.2s;
}

.filter-chip i:hover {
    color: #ef4444;
}

.clear-all {
    background: none;
    border: none;
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 40px;
    transition: all 0.2s;
}

.clear-all:hover {
    background: #fef2f2;
}

.results-count {
    color: #64748b;
    font-size: 14px;
}

.results-count strong {
    color: #0f172a;
    font-size: 18px;
}

/* ============================================
   RESULTS GRID - BEAUTIFUL CARDS
   ============================================ */
.results-section {
    padding: 60px 0;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 32px;
    margin-bottom: 60px;
}

/* Professional Card - Premium Design */
.pro-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.pro-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #fbbf24, #f59e0b, #fbbf24);
    transform: scaleX(0);
    transition: transform 0.3s;
}

.pro-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.pro-card:hover::before {
    transform: scaleX(1);
}

/* Card Cover Image */
.card-cover {
    height: 160px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.card-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-cover::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
}

/* Avatar */
.avatar-wrapper {
    position: relative;
    margin-top: -40px;
    padding: 0 20px;
}

.avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    object-fit: cover;
    background: white;
}

.avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid white;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.online-badge {
    position: absolute;
    bottom: 4px;
    right: 24px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border-radius: 50%;
    border: 2px solid white;
}

/* Card Content */
.card-content {
    padding: 20px;
}

.pro-name {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.verified-badge {
    color: #3b82f6;
    font-size: 16px;
    cursor: help;
}

.pro-title {
    font-size: 13px;
    font-weight: 600;
    color: #f59e0b;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}

.pro-location {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
}

/* Rating Section */
.rating-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 16px;
}

.stars {
    color: #fbbf24;
    font-size: 14px;
    letter-spacing: 2px;
}

.rating-value {
    font-weight: 700;
    color: #0f172a;
    margin-left: 8px;
}

.review-count {
    font-size: 12px;
    color: #94a3b8;
}

/* Skills Tags */
.skills-section {
    margin-bottom: 20px;
}

.skill-tag {
    display: inline-block;
    padding: 4px 12px;
    background: #f1f5f9;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: #334155;
    margin: 0 4px 8px 0;
    transition: all 0.2s;
}

.skill-tag:hover {
    background: #fbbf24;
    color: #0f172a;
    transform: translateY(-1px);
}

/* Card Footer */
.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}

.price {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
}

.price small {
    font-size: 12px;
    font-weight: 500;
    color: #94a3b8;
}

.view-btn {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 40px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.view-btn:hover {
    transform: translateX(4px);
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
}

/* ============================================
   EMPTY STATE - BEAUTIFUL
   ============================================ */
.empty-state {
    text-align: center;
    padding: 100px 20px;
    background: white;
    border-radius: 32px;
    margin: 40px 0;
}

.empty-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 24px;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon i {
    font-size: 48px;
    color: #94a3b8;
}

.empty-state h3 {
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
}

.empty-state p {
    color: #64748b;
    font-size: 16px;
    margin-bottom: 32px;
}

.empty-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
}

.btn-reset {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #0f172a;
    padding: 12px 28px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.2s;
}

.btn-reset:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(245,158,11,0.3);
}

.btn-home {
    background: #f1f5f9;
    color: #334155;
    padding: 12px 28px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-home:hover {
    background: #e2e8f0;
}

/* ============================================
   PAGINATION - ELEGANT
   ============================================ */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination {
    display: flex;
    gap: 8px;
    background: white;
    padding: 8px;
    border-radius: 60px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
    padding: 0 12px;
    background: transparent;
    border-radius: 40px;
    color: #334155;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.pagination .page-link:hover {
    background: #f1f5f9;
    color: #f59e0b;
}

.pagination .active .page-link {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #0f172a;
    font-weight: 700;
}

/* ============================================
   FOOTER - MODERN & CLEAN
   ============================================ */
.footer {
    background: #0f172a;
    color: #cbd5e1;
    padding: 60px 0 20px;
    margin-top: 60px;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 48px;
    margin-bottom: 48px;
}

.footer-col h4 {
    color: white;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.footer-col h4::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #fbbf24;
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 14px;
}

.footer-links a:hover {
    color: #fbbf24;
    transform: translateX(4px);
    display: inline-block;
}

.social-links {
    display: flex;
    gap: 16px;
    margin-top: 20px;
}

.social-links a {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e1;
    transition: all 0.2s;
}

.social-links a:hover {
    background: #fbbf24;
    color: #0f172a;
    transform: translateY(-3px);
}

.newsletter-form {
    display: flex;
    gap: 8px;
    margin-top: 16px;
}

.newsletter-input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid #334155;
    background: #1e293b;
    border-radius: 40px;
    color: white;
    outline: none;
}

.newsletter-input::placeholder {
    color: #64748b;
}

.newsletter-btn {
    background: #fbbf24;
    border: none;
    padding: 0 20px;
    border-radius: 40px;
    color: #0f172a;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.newsletter-btn:hover {
    background: #f59e0b;
    transform: translateY(-2px);
}

.footer-bottom {
    text-align: center;
    padding-top: 32px;
    border-top: 1px solid #1e293b;
    font-size: 13px;
    color: #64748b;
}

/* ============================================
   LOADING ANIMATION
   ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.pro-card {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
}

.pro-card:nth-child(1) { animation-delay: 0.05s; }
.pro-card:nth-child(2) { animation-delay: 0.1s; }
.pro-card:nth-child(3) { animation-delay: 0.15s; }
.pro-card:nth-child(4) { animation-delay: 0.2s; }
.pro-card:nth-child(5) { animation-delay: 0.25s; }
.pro-card:nth-child(6) { animation-delay: 0.3s; }

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .container {
        padding: 0 20px;
    }
    
    .search-title {
        font-size: 32px;
    }
    
    .search-form {
        flex-direction: column;
        background: transparent;
        padding: 0;
        gap: 12px;
    }
    
    .search-input {
        background: white;
    }
    
    .search-btn {
        justify-content: center;
        padding: 14px;
    }
    
    .results-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .filters-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .newsletter-btn {
        padding: 12px;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
        border-radius: 20px;
    }
}

@media (max-width: 480px) {
    .search-title {
        font-size: 28px;
    }
    
    .stats-badge {
        font-size: 12px;
        padding: 8px 16px;
    }
    
    .stats-number {
        font-size: 18px;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-reset, .btn-home {
        width: 100%;
        text-align: center;
    }
}
</style>
@endpush

@section('content')

<!-- ============================================
     BEAUTIFUL SEARCH HEADER
     ============================================ -->
<div class="search-header">
    <div class="container">
        <h1 class="search-title">
            Find Your Perfect 
            <span>
                @if(request('keyword'))
                    {{ request('keyword') }}
                @elseif(request('category'))
                    {{ request('category') }}
                @else
                    Professional
                @endif
            </span>
        </h1>
        <p class="search-subtitle">Connect with top-rated construction experts and professionals</p>
        
        <div class="search-form-wrapper">
            <form method="GET" action="{{ route('search.professionals') }}" class="search-form">
                <input type="text" name="keyword" class="search-input" 
                       placeholder="Search by profession, name, or skill..." 
                       value="{{ request('keyword') }}">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        
        <div class="stats-badge">
            <i class="fas fa-chart-line"></i>
            <span><span class="stats-number">{{ number_format($professionals->total()) }}</span> Verified Professionals</span>
            <i class="fas fa-map-marker-alt"></i>
            <span>Available Nationwide</span>
        </div>
    </div>
</div>

<!-- ============================================
     FILTERS BAR
     ============================================ -->
@if(request('keyword') || request('category') || request('location') || request('lat'))
<div class="filters-bar">
    <div class="container">
        <div class="filters-content">
            <div class="active-filters">
                @if(request('keyword'))
                <div class="filter-chip">
                    <i class="fas fa-search"></i> "{{ request('keyword') }}"
                    <i class="fas fa-times" onclick="removeFilter('keyword')"></i>
                </div>
                @endif
                
                @if(request('category'))
                <div class="filter-chip">
                    <i class="fas fa-tag"></i> {{ request('category') }}
                    <i class="fas fa-times" onclick="removeFilter('category')"></i>
                </div>
                @endif
                
                @if(request('location'))
                <div class="filter-chip">
                    <i class="fas fa-map-marker-alt"></i> {{ request('location') }}
                    <i class="fas fa-times" onclick="removeFilter('location')"></i>
                </div>
                @endif
                
                @if(request('lat'))
                <div class="filter-chip">
                    <i class="fas fa-globe"></i> Within {{ request('radius', 50) }}km
                    <i class="fas fa-times" onclick="removeFilter('lat');removeFilter('lng');removeFilter('radius')"></i>
                </div>
                @endif
            </div>
            
            <div class="results-count">
                Showing <strong>{{ $professionals->firstItem() ?? 0 }}</strong> to <strong>{{ $professionals->lastItem() ?? 0 }}</strong> of <strong>{{ number_format($professionals->total()) }}</strong> results
            </div>
            
            @if(request('keyword') || request('category') || request('location') || request('lat'))
            <button class="clear-all" onclick="clearAllFilters()">
                <i class="fas fa-trash-alt"></i> Clear All
            </button>
            @endif
        </div>
    </div>
</div>
@endif

<!-- ============================================
     MAIN RESULTS SECTION
     ============================================ -->
<section class="results-section">
    <div class="container">
        
        @if($professionals->total() > 0)
            <div class="results-grid">
                @foreach($professionals as $professional)
                <div class="pro-card">
                    <div class="card-cover">
                        @if($professional->cover_photo)
                            <img src="{{ Storage::url($professional->cover_photo) }}" alt="{{ $professional->name }}">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%)"></div>
                        @endif
                    </div>
                    
                    <div class="avatar-wrapper">
                        @if($professional->avatar)
                            <img src="{{ Storage::url($professional->avatar) }}" class="avatar" alt="{{ $professional->name }}">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper(substr($professional->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="online-badge"></div>
                    </div>
                    
                    <div class="card-content">
                        <div class="pro-name">
                            {{ $professional->name }}
                            <i class="fas fa-check-circle verified-badge" title="Verified Professional"></i>
                        </div>
                        <div class="pro-title">{{ $professional->category ?? 'Professional' }}</div>
                        <div class="pro-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $professional->location ?? 'Location available upon request' }}
                        </div>
                        
                        <div class="rating-section">
                            <div class="stars">
                                @php
                                    $rating = $professional->rating ?? 4.5;
                                    $fullStars = floor($rating);
                                    $halfStar = $rating - $fullStars >= 0.5;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <i class="fas fa-star"></i>
                                    @elseif($halfStar && $i == $fullStars + 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="rating-value">{{ number_format($rating, 1) }}</span>
                            </div>
                            <div class="review-count">
                                ({{ $professional->reviews_count ?? 0 }} reviews)
                            </div>
                        </div>
                        
                        <div class="skills-section">
                            @php
                                $skills = $professional->skills ?? ['Expert', 'Professional', 'Certified'];
                                $displaySkills = array_slice($skills, 0, 3);
                            @endphp
                            @foreach($displaySkills as $skill)
                                <span class="skill-tag">{{ $skill }}</span>
                            @endforeach
                            @if(count($skills) > 3)
                                <span class="skill-tag">+{{ count($skills) - 3 }} more</span>
                            @endif
                        </div>
                        
                        <div class="card-footer">
                            <div class="price">
                                @if($professional->hourly_rate)
                                    ${{ $professional->hourly_rate }}<small>/hr</small>
                                @else
                                    Contact for pricing<small></small>
                                @endif
                            </div>
                            <a href="{{ route('professionals.show', $professional) }}" class="view-btn">
                                View Profile <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($professionals->hasPages())
            <div class="pagination-wrapper">
                <ul class="pagination">
                    {{ $professionals->appends(request()->query())->links() }}
                </ul>
            </div>
            @endif
            
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h3>No professionals found</h3>
                <p>We couldn't find any professionals matching your search criteria.</p>
                <div class="empty-actions">
                    <a href="{{ route('search.professionals') }}" class="btn-reset">
                        <i class="fas fa-sync-alt"></i> Reset All Filters
                    </a>
                    <a href="{{ route('home') }}" class="btn-home">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        @endif
        
    </div>
</section>


<script>
// Remove single filter
function removeFilter(filter) {
    const url = new URL(window.location.href);
    url.searchParams.delete(filter);
    window.location.href = url.toString();
}

// Clear all filters
function clearAllFilters() {
    window.location.href = "{{ route('search.professionals') }}";
}

// Smooth scroll to top when pagination clicks
document.querySelectorAll('.pagination .page-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        if (href) {
            window.location.href = href;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
});
</script>

@endsection