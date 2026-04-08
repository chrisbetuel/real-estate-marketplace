@extends('layouts.app')

@section('title', 'Find Professionals - BuildConnect')

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
                Connect with top-rated professionals for your real estate projects
            </p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="search-card">
                <form method="GET" action="{{ route('professionals.index') }}">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="search-input" 
                               placeholder="Search by name, profession, or expertise..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="search-btn">Search</button>
                    </div>
                </form>
                
                @if(request('search'))
                    <div class="active-filter mt-3">
                        <span class="filter-badge">
                            Searching for: "{{ request('search') }}"
                            <a href="{{ route('professionals.index') }}" class="clear-filter">×</a>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Professionals Grid -->
    <div class="row">
        @forelse($professionals as $professional)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="professional-card">
                <!-- Verified Badge -->
                @if($professional->is_verified)
                    <div class="verified-badge">
                        <i class="fas fa-check-circle"></i> Verified
                    </div>
                @endif
                
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="{{ $professional->profile_image_url }}" alt="{{ $professional->name }}">
                    </div>
                    <div class="profile-name">
                        <h3>{{ $professional->name }}</h3>
                        @if($professional->professionalProfile)
                            <p class="profession">{{ $professional->professionalProfile->profession ?? 'Professional' }}</p>
                        @endif
                    </div>
                </div>
                
                <!-- Rating Section -->
                <div class="rating-section">
                    <div class="stars">
                        @php
                            $rating = $professional->rating ?? 0;
                            $fullStars = floor($rating);
                            $halfStar = $rating - $fullStars >= 0.5;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                <i class="fas fa-star"></i>
                            @elseif($i == $fullStars + 1 && $halfStar)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="rating-number">{{ number_format($rating, 1) }}</span>
                    </div>
                    <div class="review-count">{{ $professional->reviews_count ?? 0 }} reviews</div>
                </div>
                
                <!-- Details -->
                <div class="details-section">
                    @if($professional->professionalProfile)
                        @if($professional->professionalProfile->years_experience)
                            <div class="detail-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $professional->professionalProfile->years_experience }} years experience</span>
                            </div>
                        @endif
                        @if($professional->professionalProfile->hourly_rate)
                            <div class="detail-item">
                                <i class="fas fa-dollar-sign"></i>
                                <span>${{ number_format($professional->professionalProfile->hourly_rate) }}/hour</span>
                            </div>
                        @endif
                    @endif
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $professional->address ?? 'Location not specified' }}</span>
                    </div>
                </div>
                
                <!-- Skills Section -->
                @if($professional->professionalProfile && $professional->professionalProfile->skills)
                    <div class="skills-section">
                        @php
                            $skills = is_array($professional->professionalProfile->skills) 
                                ? $professional->professionalProfile->skills 
                                : json_decode($professional->professionalProfile->skills, true) ?? [];
                        @endphp
                        @foreach(array_slice($skills, 0, 3) as $skill)
                            <span class="skill-tag">{{ $skill }}</span>
                        @endforeach
                        @if(count($skills) > 3)
                            <span class="skill-tag">+{{ count($skills) - 3 }} more</span>
                        @endif
                    </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('professionals.show', $professional) }}" class="btn-profile">
                        <i class="fas fa-user-circle me-2"></i>View Profile
                    </a>
                    <a href="{{ route('professionals.show', $professional) }}#contact" class="btn-message">
                        <i class="fas fa-envelope me-2"></i>Contact
                    </a>
                </div>
                
                <!-- Status Badge -->
                <div class="status-badge">
                    @if($professional->is_verified)
                        <span class="status-verified">
                            <i class="fas fa-check-circle"></i> Available for work
                        </span>
                    @else
                        <span class="status-pending">
                            <i class="fas fa-clock"></i> Verification pending
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>No Professionals Found</h3>
                <p>We couldn't find any professionals matching "{{ request('search') }}".</p>
                <a href="{{ route('professionals.index') }}" class="btn-clear-search">
                    <i class="fas fa-arrow-left me-2"></i>Clear Search
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
    /* Search Card */
    .search-card {
        background: var(--white);
        border-radius: 24px;
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
    
    /* Professional Cards */
    .professional-card {
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
    
    .professional-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
        border-color: var(--brand-gold);
    }
    
    .verified-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .profile-header {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        align-items: center;
    }
    
    .profile-avatar {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--brand-gold);
    }
    
    .profile-name h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--brand-dark);
        margin-bottom: 4px;
    }
    
    .profile-name .profession {
        font-size: 0.8rem;
        color: var(--gray-600);
        margin-bottom: 0;
    }
    
    .rating-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .stars {
        display: flex;
        align-items: center;
        gap: 2px;
    }
    
    .stars i {
        font-size: 0.8rem;
        color: #fbbf24;
    }
    
    .stars .far.fa-star {
        color: var(--gray-300);
    }
    
    .rating-number {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-left: 4px;
    }
    
    .review-count {
        font-size: 0.7rem;
        color: var(--gray-500);
    }
    
    .details-section {
        margin-bottom: 1rem;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 0.8rem;
        color: var(--gray-700);
    }
    
    .detail-item i {
        width: 18px;
        color: var(--brand-gold);
        font-size: 0.8rem;
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
    
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 1rem;
    }
    
    .btn-profile, .btn-message {
        flex: 1;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .btn-profile {
        background: transparent;
        border: 1px solid var(--brand-gold);
        color: var(--brand-gold);
    }
    
    .btn-profile:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
        transform: translateY(-2px);
    }
    
    .btn-message {
        background: var(--brand-dark);
        border: 1px solid var(--brand-dark);
        color: var(--white);
    }
    
    .btn-message:hover {
        background: transparent;
        color: var(--brand-dark);
        transform: translateY(-2px);
    }
    
    .status-badge {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }
    
    .status-verified {
        font-size: 0.7rem;
        color: #059669;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-pending {
        font-size: 0.7rem;
        color: #d97706;
        display: flex;
        align-items: center;
        gap: 6px;
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
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection