@extends('layouts.app')

@section('title', $store->store_name . ' - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stores.index') }}">Stores</a></li>
                <li class="breadcrumb-item active">{{ $store->store_name }}</li>
            </ol>
        </nav>

        <!-- Store Header Card -->
        <div class="store-header-card">
            <div class="store-header-inner">
                <div class="store-logo-section">
                    <img src="{{ $store->logo ?? 'https://via.placeholder.com/150x150/2563EB/FFFFFF?text=' . urlencode(substr($store->store_name, 0, 1)) }}" 
                         alt="{{ $store->store_name }}"
                         class="store-logo">
                    @if($store->images && count($store->images) > 0)
                        <div class="store-gallery">
                            <span class="gallery-label">Store Gallery</span>
                            <div class="gallery-thumbs">
                                @foreach(array_slice($store->images, 0, 4) as $image)
                                    <img src="{{ $image }}" class="gallery-thumb" onclick="openImageModal('{{ $image }}')" alt="Gallery image">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="store-info-section">
                    <div class="store-badge">
                        @if($store->is_verified)
                            <span class="verified-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Verified Store
                            </span>
                        @endif
                    </div>
                    <h1 class="store-name">{{ $store->store_name }}</h1>
                    <p class="store-specialization">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-1.41 1.41a2 2 0 0 1-2.82 0L12 10.24a2 2 0 0 1 0-2.82l1.41-1.41"/>
                            <path d="M8 7L4 3M21 16l-4 4"/>
                            <path d="M16 21l-4-4 4-4 4 4-4 4z"/>
                        </svg>
                        {{ $store->specialization ?? 'Construction Materials & Equipment' }}
                    </p>
                    <div class="store-contact-info">
                        <div class="contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>{{ $store->store_address ?? 'Address not specified' }}</span>
                        </div>
                        <div class="contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span>{{ $store->store_phone ?? 'Phone not available' }}</span>
                        </div>
                        @if($store->store_email)
                        <div class="contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span>{{ $store->store_email }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="store-actions-section">
                    @auth
                        @if(Auth::user()->user_type == 'client')
                            <a href="{{ route('messages.start-store', $store) }}" class="btn-contact">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                                Contact Store
                            </a>
                        @endif
                        
                        @if(Auth::user()->user_type == 'store_owner' && Auth::user()->store && Auth::user()->store->id == $store->id)
                            <a href="{{ route('stores.edit', $store) }}" class="btn-edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                    <path d="M4 20h16"/>
                                </svg>
                                Edit Store
                            </a>
                        @endif
                    @endauth
                    
                    @guest
                        <a href="{{ route('login') }}" class="btn-contact">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Login to Contact
                        </a>
                    @endguest
                </div>
            </div>
            
            @if($store->description)
                <div class="store-description">
                    <h4>About the Store</h4>
                    <p>{{ $store->description }}</p>
                </div>
            @endif
            
            @if($store->business_hours)
                <div class="store-hours">
                    <h4>Business Hours</h4>
                    <div class="hours-grid">
                        @foreach($store->business_hours as $day => $hours)
                            <div class="hour-item">
                                <span class="hour-day">{{ $day }}</span>
                                <span class="hour-time">{{ $hours }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Products Section -->
        <div class="products-section-header">
            <div>
                <h2>Products from <span>{{ $store->store_name }}</span></h2>
                <p>{{ $products->total() }} product{{ $products->total() != 1 ? 's' : '' }} available</p>
            </div>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-image-wrap">
                        <a href="{{ route('products.show', $product) }}">
                            <img src="{{ $product->images[0] ?? 'https://via.placeholder.com/300x200/F1F5F9/64748B?text=No+Image' }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-image"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="product-image-placeholder" style="display: none;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="M21 15l-5-5L5 21"/>
                                </svg>
                            </div>
                        </a>
                        <div class="product-badge {{ $product->type }}">
                            {{ $product->type == 'sale' ? 'For Sale' : ($product->type == 'rent' ? 'For Rent' : 'Product') }}
                        </div>
                    </div>
                    
                    <div class="product-body">
                        <h4 class="product-title">
                            <a href="{{ route('products.show', $product) }}">{{ Str::limit($product->name, 40) }}</a>
                        </h4>
                        <p class="product-description">{{ Str::limit($product->description ?? 'No description available', 70) }}</p>
                        
                        <div class="product-pricing">
                            @if($product->type == 'sale' && $product->price_sale)
                                <div class="price-sale">${{ number_format($product->price_sale, 2) }}</div>
                            @endif
                            @if($product->type == 'rent' && $product->price_rent)
                                <div class="price-rent">
                                    ${{ number_format($product->price_rent, 2) }}
                                    <span class="price-period">/ {{ $product->rent_period ?? 'day' }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="product-footer">
                            <div class="product-stock">
                                @if(($product->quantity ?? 0) > 10)
                                    <span class="stock-in">✓ In Stock</span>
                                @elseif(($product->quantity ?? 0) > 0)
                                    <span class="stock-low">Only {{ $product->quantity }} left</span>
                                @else
                                    <span class="stock-out">Out of Stock</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="view-product-btn">
                                View Details
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M3 9h18"/>
                            <path d="M9 21V9"/>
                        </svg>
                    </div>
                    <h4>No Products Available</h4>
                    <p>This store hasn't added any products yet. Check back soon!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="pagination-container">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" style="display: none;">
    <div class="image-modal-content">
        <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
        <img id="modalImage" src="" alt="Enlarged image">
    </div>
</div>
@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════
   STORE PAGE - AMERICAN STYLE
   Clean | Modern | Professional | Functional
═══════════════════════════════════════════ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-container {
    background: #F1F5F9;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
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

/* Breadcrumb */
.breadcrumb-nav {
    margin-bottom: 24px;
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item {
    font-size: 13px;
    font-weight: 500;
}

.breadcrumb-item a {
    color: #2563EB;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: #1D4ED8;
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #0F172A;
    font-weight: 600;
}

.breadcrumb-item:not(:first-child)::before {
    content: "›";
    margin-right: 8px;
    color: #94A3B8;
    font-size: 16px;
}

/* Store Header Card */
.store-header-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    margin-bottom: 48px;
}

.store-header-inner {
    display: flex;
    flex-wrap: wrap;
    gap: 32px;
    padding: 32px;
    border-bottom: 1px solid #F1F5F9;
}

/* Logo Section */
.store-logo-section {
    flex-shrink: 0;
    text-align: center;
    min-width: 180px;
}

.store-logo {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #2563EB;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.store-gallery {
    margin-top: 12px;
}

.gallery-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.gallery-thumbs {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.gallery-thumb {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid #E2E8F0;
}

.gallery-thumb:hover {
    transform: scale(1.1);
    border-color: #2563EB;
}

/* Store Info Section */
.store-info-section {
    flex: 1;
}

.store-badge {
    margin-bottom: 8px;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: #ECFDF5;
    color: #059669;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.store-name {
    font-size: 28px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 8px 0;
}

.store-specialization {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #2563EB;
    margin-bottom: 16px;
}

.store-contact-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 8px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #475569;
}

.contact-item svg {
    stroke: #2563EB;
    flex-shrink: 0;
}

/* Store Actions */
.store-actions-section {
    flex-shrink: 0;
    min-width: 160px;
}

.btn-contact, .btn-edit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-contact {
    background: #2563EB;
    color: white;
    border: none;
}

.btn-contact:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
}

.btn-edit {
    background: transparent;
    color: #475569;
    border: 1px solid #E2E8F0;
}

.btn-edit:hover {
    border-color: #2563EB;
    color: #2563EB;
    background: #EFF6FF;
}

/* Store Description */
.store-description {
    padding: 24px 32px;
    border-bottom: 1px solid #F1F5F9;
}

.store-description h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 12px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.store-description p {
    font-size: 14px;
    color: #475569;
    line-height: 1.6;
    margin: 0;
}

/* Store Hours */
.store-hours {
    padding: 24px 32px;
}

.store-hours h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 16px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
}

.hour-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #F1F5F9;
}

.hour-day {
    font-size: 13px;
    font-weight: 500;
    color: #0F172A;
}

.hour-time {
    font-size: 13px;
    color: #64748B;
}

/* Products Section Header */
.products-section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
}

.products-section-header h2 {
    font-size: 22px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 6px 0;
}

.products-section-header h2 span {
    color: #2563EB;
}

.products-section-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    transition: all 0.2s;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -8px rgba(0,0,0,0.1);
    border-color: #CBD5E1;
}

.product-image-wrap {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: #F1F5F9;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-image-placeholder {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    background: #F1F5F9;
}

.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: white;
}

.product-badge.sale {
    background: #10B981;
}

.product-badge.rent {
    background: #8B5CF6;
}

.product-badge.default {
    background: #6B7280;
}

.product-body {
    padding: 16px;
}

.product-title {
    margin: 0 0 8px 0;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.4;
}

.product-title a {
    color: #0F172A;
    text-decoration: none;
    transition: color 0.2s;
}

.product-title a:hover {
    color: #2563EB;
}

.product-description {
    font-size: 12px;
    color: #64748B;
    line-height: 1.5;
    margin-bottom: 12px;
}

.product-pricing {
    margin-bottom: 12px;
}

.price-sale {
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
}

.price-rent {
    font-size: 16px;
    font-weight: 700;
    color: #0F172A;
}

.price-period {
    font-size: 11px;
    font-weight: 500;
    color: #64748B;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #F1F5F9;
}

.product-stock {
    font-size: 11px;
    font-weight: 600;
}

.stock-in {
    color: #10B981;
}

.stock-low {
    color: #F59E0B;
}

.stock-out {
    color: #94A3B8;
}

.view-product-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s;
}

.view-product-btn:hover {
    background: #EFF6FF;
    border-color: #2563EB;
    color: #2563EB;
}

.view-product-btn svg {
    transition: transform 0.2s;
}

.view-product-btn:hover svg {
    transform: translateX(2px);
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.empty-icon {
    margin-bottom: 16px;
}

.empty-state h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1E293B;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 24px;
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
    min-width: 36px;
    height: 36px;
    padding: 0 8px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    color: #1E293B;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
}

.pagination-container .page-item.active .page-link {
    background: #2563EB;
    border-color: #2563EB;
    color: white;
}

.pagination-container .page-item .page-link:hover {
    border-color: #2563EB;
    color: #2563EB;
}

/* Image Modal */
.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.image-modal-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
}

.image-modal-content img {
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;
    border-radius: 8px;
}

.image-modal-close {
    position: absolute;
    top: -40px;
    right: 0;
    font-size: 32px;
    color: white;
    cursor: pointer;
    transition: opacity 0.2s;
}

.image-modal-close:hover {
    opacity: 0.7;
}

/* Responsive */
@media (max-width: 900px) {
    .store-header-inner {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .store-info-section {
        text-align: center;
    }
    
    .store-contact-info {
        align-items: center;
    }
    
    .store-actions-section {
        width: 100%;
        max-width: 250px;
    }
    
    .hours-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 24px 0;
    }
    
    .container {
        padding: 0 16px;
    }
    
    .store-header-inner {
        padding: 24px;
    }
    
    .store-description, .store-hours {
        padding: 20px 24px;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
    }
    
    .products-section-header {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 480px) {
    .store-name {
        font-size: 22px;
    }
    
    .store-logo {
        width: 100px;
        height: 100px;
    }
    
    .gallery-thumb {
        width: 30px;
        height: 30px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function openImageModal(imageUrl) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modal.style.display = 'flex';
    modalImg.src = imageUrl;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.getElementById('imageModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush