@extends('layouts.app')

@section('title', $stage_name . ' Professionals - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="stage-header">
                <div class="stage-icon">
                    <i class="{{ $stage_info['icon'] }}"></i>
                </div>
                <div>
                    <h1 class="fw-bold mb-2">{{ $stage_name }}</h1>
                    <p class="text-muted">{{ $stage_info['description'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="professionals-grid">
                @forelse($professionals as $pro)
                    <div class="professional-card">
                        @if($pro['verified'])
                            <div class="verified-badge">
                                <i class="fas fa-check-circle"></i> Verified
                            </div>
                        @endif
                        <div class="professional-avatar">
                            <img src="{{ $pro['avatar'] }}" alt="{{ $pro['name'] }}">
                        </div>
                        <h4 class="professional-name">{{ $pro['name'] }}</h4>
                        <div class="professional-title">{{ $pro['profession'] }}</div>
                        <div class="professional-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($pro['rating']))
                                        <i class="fas fa-star"></i>
                                    @elseif($i == floor($pro['rating']) + 1 && $pro['rating'] - floor($pro['rating']) >= 0.5)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span>({{ $pro['reviews_count'] }} reviews)</span>
                        </div>
                        <div class="professional-details">
                            <div class="detail-item">
                                <span class="detail-label">Experience</span>
                                <span class="detail-value">{{ $pro['years_experience'] ?? 'N/A' }} years</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Hourly Rate</span>
                                <span class="detail-value">${{ number_format($pro['hourly_rate'] ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="professional-skills">
                            @foreach($pro['skills'] as $skill)
                                <span class="skill-tag">{{ $skill }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('professionals.show', $pro['id']) }}" class="btn-contact">
                            View Profile →
                        </a>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <p>No professionals found in this category yet.</p>
                        @auth
                            @if(Auth::user()->user_type == 'professional')
                                <a href="{{ route('profile.edit') }}" class="btn-primary-custom mt-3">
                                    Update Your Profile
                                </a>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stage-header {
        display: flex;
        align-items: center;
        gap: 20px;
        background: white;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
    }
    
    .stage-icon {
        width: 70px;
        height: 70px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stage-icon i {
        font-size: 2rem;
        color: var(--brand-gold);
    }
    
    .professionals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    
    .professional-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
        position: relative;
    }
    
    .professional-card:hover {
        transform: translateY(-4px);
        border-color: var(--brand-gold);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }
    
    .verified-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #ECFDF5;
        color: #059669;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 500;
    }
    
    .professional-avatar {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
    }
    
    .professional-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--brand-gold);
    }
    
    .professional-name {
        text-align: center;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .professional-title {
        text-align: center;
        font-size: 0.8rem;
        color: var(--brand-gold);
        margin-bottom: 12px;
    }
    
    .professional-rating {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 16px;
    }
    
    .stars {
        display: flex;
        gap: 2px;
    }
    
    .stars i {
        font-size: 0.7rem;
        color: #fbbf24;
    }
    
    .professional-rating span {
        font-size: 0.7rem;
        color: var(--gray-500);
    }
    
    .professional-details {
        margin-bottom: 16px;
        padding-top: 12px;
        border-top: 1px solid var(--gray-200);
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        margin-bottom: 8px;
    }
    
    .detail-label {
        color: var(--gray-500);
    }
    
    .detail-value {
        font-weight: 500;
        color: var(--gray-700);
    }
    
    .professional-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 16px;
    }
    
    .skill-tag {
        padding: 4px 10px;
        background: var(--gray-100);
        border-radius: 20px;
        font-size: 0.7rem;
        color: var(--gray-600);
    }
    
    .btn-contact {
        width: 100%;
        padding: 10px;
        background: transparent;
        border: 1px solid var(--brand-gold);
        color: var(--brand-gold);
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.8rem;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.2s;
    }
    
    .btn-contact:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
    }
    
    .empty-state i {
        font-size: 3rem;
        color: var(--gray-400);
        margin-bottom: 16px;
    }
    
    .empty-state p {
        color: var(--gray-500);
        margin-bottom: 0;
    }
    
    .btn-primary-custom {
        display: inline-block;
        padding: 10px 24px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .stage-header {
            flex-direction: column;
            text-align: center;
        }
        .professionals-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection