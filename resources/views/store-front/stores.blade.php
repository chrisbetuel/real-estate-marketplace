@extends('layouts.app')

@section('title', 'Stores - BuildConnect')

@section('content')
<div class="stores-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>Our <span>Stores</span></h1>
            <p>Discover quality products from trusted partners</p>
        </div>

        <!-- Search Bar -->
        <div class="search-section">
            <form method="GET" action="{{ route('shop.stores') }}" class="search-form">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" 
                           placeholder="Search stores by name or location..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="search-btn">Search</button>
                </div>
            </form>
            
            @if(request('search'))
                <div class="active-filter">
                    <span class="filter-tag">
                        "{{ request('search') }}"
                        <a href="{{ route('shop.stores') }}" class="remove-filter">×</a>
                    </span>
                </div>
            @endif
        </div>

        <!-- Stores List -->
        <div class="stores-list">
            @forelse($stores as $store)
                <div class="store-item">
                    <!-- Store Logo / Icon -->
                    <div class="store-icon">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}">
                        @else
                            <div class="icon-placeholder">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="8" width="18" height="14" rx="2"/>
                                    <path d="M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Store Details -->
                    <div class="store-details">
                        <div class="store-header">
                            <h3 class="store-name">{{ $store->name }}</h3>
                            <div class="store-actions">
                                <a href="{{ route('shop.store', $store->id) }}" class="btn-view">View Profile</a>
                                <a href="{{ route('shop.store', $store->id) }}?enquiry=1" class="btn-enquiry">Send Enquiry</a>
                            </div>
                        </div>

                        <!-- Store Address -->
                        <div class="store-address">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>{{ $store->address ?? $store->location ?? $store->city ?? 'No address provided' }}, {{ $store->city ?? '' }}</span>
                        </div>

                        <!-- Store Stats Row -->
                        <div class="store-stats">
                            @if($store->is_verified ?? true)
                                <span class="stat-badge verified">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    Verified
                                </span>
                            @endif
                            @if($store->years_active ?? false)
                                <span class="stat-badge years">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ $store->years_active }}+ Years with us
                                </span>
                            @else
                                <span class="stat-badge years">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($store->created_at)->diffInYears() }}+ Years with us
                                </span>
                            @endif
                        </div>

                        <!-- Contact & Info Row -->
                        <div class="store-contact">
                            @if($store->phone)
                                <span class="contact-item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    {{ $store->phone }}
                                </span>
                            @endif
                            @if($store->established_year)
                                <span class="contact-item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    {{ $store->established_year }} Established
                                </span>
                            @else
                                <span class="contact-item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    Since {{ $store->created_at->format('Y') }}
                                </span>
                            @endif
                        </div>

                        <!-- Action Links -->
                        <div class="store-links">
                            <a href="#" class="link-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                                Email
                            </a>
                            <a href="#" class="link-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                Map
                            </a>
                            <a href="#" class="link-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                                    <circle cx="12" cy="12" r="3"/>
                                    <line x1="18.5" y1="5.5" x2="19.5" y2="5.5"/>
                                </svg>
                                {{ $store->products_count ?? 0 }} Photos
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                        <rect x="3" y="8" width="18" height="14" rx="2"/>
                        <path d="M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                    </svg>
                    <h3>No stores found</h3>
                    <p>We couldn't find any stores matching "{{ request('search') }}"</p>
                    <a href="{{ route('shop.stores') }}" class="empty-link">Clear search →</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($stores->hasPages())
            <div class="pagination-wrapper">
                {{ $stores->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
/* ============================================
   STORES PAGE - LIST LAYOUT (FAITH STORE STYLE)
   Dark #1A2C3E | Gold #C6A43B
============================================ */

.stores-page {
    background: #F5F7FA;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.page-header {
    text-align: center;
    margin-bottom: 28px;
}

.page-header h1 {
    font-size: 26px;
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

/* Search Section */
.search-section {
    margin-bottom: 28px;
}

.search-form {
    margin-bottom: 12px;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 14px;
    color: #9CA3AF;
    pointer-events: none;
}

.search-input {
    width: 100%;
    padding: 11px 100px 11px 42px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    font-size: 13px;
    background: white;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #C6A43B;
    box-shadow: 0 0 0 2px rgba(198,164,59,0.08);
}

.search-btn {
    position: absolute;
    right: 4px;
    padding: 7px 20px;
    background: #C6A43B;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.search-btn:hover {
    background: #AD8E32;
}

.active-filter {
    margin-top: 12px;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 20px;
    font-size: 12px;
    color: #5A6E85;
}

.remove-filter {
    color: #9CA3AF;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
}

.remove-filter:hover {
    color: #EF4444;
}

/* Stores List */
.stores-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Store Item - Faith Store Style */
.store-item {
    background: white;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    gap: 20px;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.store-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border-color: #CBD5E1;
}

/* Store Icon */
.store-icon {
    flex-shrink: 0;
}

.store-icon img {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
}

.icon-placeholder {
    width: 64px;
    height: 64px;
    background: #F0F2F5;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-placeholder svg {
    stroke: #8A99B0;
}

/* Store Details */
.store-details {
    flex: 1;
}

.store-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 8px;
}

.store-name {
    font-size: 18px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}

.store-actions {
    display: flex;
    gap: 10px;
}

.btn-view, .btn-enquiry {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view {
    background: #1A2C3E;
    color: white;
}

.btn-view:hover {
    background: #2A3E52;
}

.btn-enquiry {
    background: transparent;
    border: 1px solid #C6A43B;
    color: #C6A43B;
}

.btn-enquiry:hover {
    background: rgba(198,164,59,0.1);
}

/* Store Address */
.store-address {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
}

.store-address svg {
    stroke: #C6A43B;
    flex-shrink: 0;
}

.store-address span {
    font-size: 12px;
    color: #6B7A8F;
    line-height: 1.4;
}

/* Store Stats */
.store-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 10px;
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
}

.stat-badge.verified {
    background: rgba(16,185,129,0.1);
    color: #059669;
}

.stat-badge.verified svg {
    stroke: #059669;
}

.stat-badge.years {
    background: rgba(198,164,59,0.1);
    color: #C6A43B;
}

.stat-badge.years svg {
    stroke: #C6A43B;
}

/* Store Contact */
.store-contact {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 12px;
}

.contact-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #5A6E85;
}

.contact-item svg {
    stroke: #8A99B0;
}

/* Store Links */
.store-links {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.link-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #C6A43B;
    text-decoration: none;
    transition: color 0.2s;
}

.link-item:hover {
    color: #AD8E32;
    text-decoration: underline;
}

.link-item svg {
    stroke: currentColor;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 24px;
    background: white;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
}

.empty-state svg {
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 16px;
    font-weight: 500;
    color: #1A2C3E;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 13px;
    color: #8A99B0;
    margin-bottom: 16px;
}

.empty-link {
    display: inline-block;
    color: #C6A43B;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.empty-link:hover {
    text-decoration: underline;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 32px;
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
    min-width: 34px;
    height: 34px;
    padding: 0 10px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    color: #5A6E85;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.2s;
}

.pagination-wrapper .page-item.active .page-link {
    background: #C6A43B;
    border-color: #C6A43B;
    color: white;
}

.pagination-wrapper .page-item .page-link:hover {
    border-color: #C6A43B;
    color: #C6A43B;
}

/* Responsive */
@media (max-width: 700px) {
    .store-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .store-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .store-actions {
        width: 100%;
    }
    
    .btn-view, .btn-enquiry {
        flex: 1;
        text-align: center;
    }
}

@media (max-width: 600px) {
    .stores-page {
        padding: 20px 0;
    }
    
    .page-header h1 {
        font-size: 24px;
    }
    
    .search-wrapper {
        flex-direction: column;
    }
    
    .search-icon {
        display: none;
    }
    
    .search-input {
        padding: 10px 14px;
        margin-bottom: 8px;
    }
    
    .search-btn {
        position: static;
        width: 100%;
    }
    
    .store-stats {
        flex-direction: column;
        gap: 6px;
    }
    
    .store-contact {
        flex-direction: column;
        gap: 8px;
    }
    
    .store-links {
        flex-wrap: wrap;
    }
}
</style>
@endpush
@endsection