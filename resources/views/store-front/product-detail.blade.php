@extends('layouts.app')

@section('title', $product->name . ' - BuildConnect')

@section('content')
<div class="product-page">
    <div class="ali-container">

        {{-- Breadcrumb --}}
        <div class="ali-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('shop.stores') }}">Stores</a>
            <span>/</span>
            <a href="{{ route('shop.store', $product->store->id) }}">{{ $product->store->name }}</a>
            <span>/</span>
            <span class="cur">{{ Str::limit($product->name, 40) }}</span>
        </div>

        {{-- Product Main Section --}}
        <div class="product-layout">
            {{-- LEFT COLUMN — IMAGES --}}
            <div class="product-gallery">
                <div class="main-image-container">
                    <img id="main-image" src="{{ $product->first_image ?? asset('images/no-image.png') }}" 
                         alt="{{ $product->name }}"
                         onerror="this.src='{{ asset('images/no-image.png') }}'">
                </div>
                @if($product->images && count($product->images) > 0)
                <div class="thumbnail-list">
                    @foreach($product->images as $img)
                    <div class="thumbnail-item {{ $loop->first ? 'active' : '' }}" 
                         onclick="changeImage(this, '{{ is_string($img) ? asset('storage/' . $img) : ($img['url'] ?? asset('images/no-image.png')) }}')">
                        <img src="{{ is_string($img) ? asset('storage/' . $img) : ($img['url'] ?? asset('images/no-image.png')) }}" 
                             alt="Thumbnail">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- RIGHT COLUMN — PRODUCT INFO --}}
            <div class="product-info">
                <div class="product-info-card">
                    <div class="product-brand">
                        <a href="{{ route('shop.store', $product->store->id) }}" class="brand-link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="8" width="18" height="14" rx="2"/><path d="M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
                            {{ $product->store->name }}
                        </a>
                    </div>
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    <div class="product-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">4.9 (120 reviews)</span>
                    </div>

                    <div class="product-price">
                        <span class="price-main">${{ number_format($product->price, 2) }}</span>
                        <span class="price-unit">/ piece</span>
                    </div>

                    <div class="product-stats">
                        <div class="stat-item">
                            <span class="stat-key">Availability</span>
                            @if($product->quantity > 0)
                                <span class="stat-value in-stock">In Stock ({{ $product->quantity }} units)</span>
                            @else
                                <span class="stat-value out-stock">Out of Stock</span>
                            @endif
                        </div>
                        <div class="stat-item">
                            <span class="stat-key">Category</span>
                            <span class="stat-value">{{ $product->category ?? 'General' }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-key">Sold</span>
                            <span class="stat-value">{{ $product->sold_count ?? 0 }} units</span>
                        </div>
                    </div>

                    @if($product->quantity > 0)
                    <div class="product-quantity">
                        <span class="quantity-label">Quantity</span>
                        <div class="quantity-controls">
                            <button class="qty-btn" id="qty-minus">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            </button>
                            <input type="text" id="qty-input" value="1" readonly>
                            <button class="qty-btn" id="qty-plus">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            </button>
                        </div>
                        <span class="stock-warning">Max {{ $product->quantity }} units</span>
                    </div>

                    <div class="product-actions">
                        <form id="addToCartForm" action="{{ route('shop.add-to-cart', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" id="cartQuantity" value="1">
                            <button type="submit" class="btn-add-cart">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                Add to Cart
                            </button>
                        </form>
                        <a href="{{ route('shop.cart') }}" class="btn-view-cart">View Cart</a>
                    </div>
                    @else
                        <div class="out-of-stock-message">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            This product is currently out of stock
                        </div>
                    @endif

                    <div class="product-actions-secondary">
                        <button class="btn-message" onclick="alert('Message seller: {{ $product->store->email }}')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Contact Seller
                        </button>
                        <button class="btn-wishlist">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            Wishlist
                        </button>
                    </div>
                </div>

                {{-- Trade Assurance --}}
                <div class="trade-card">
                    <div class="trade-icon">
                        <svg width="28" height="28" viewBox="0 0 40 40" fill="none">
                            <path d="M20 4L6 9v10c0 8.284 6.154 16.025 14 18 7.846-1.975 14-9.716 14-18V9L20 4z" fill="#FEF8E8" stroke="#C6A43B" stroke-width="1.5"/>
                            <path d="M14 20l4 4 8-8" stroke="#C6A43B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="trade-text">
                        <strong>Trade Assurance</strong>
                        <span>Protected payments &amp; on-time delivery</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Description Section --}}
        <div class="description-section">
            <div class="description-header">
                <h3>Product Details</h3>
            </div>
            <div class="description-body">
                <p>{{ $product->description ?? 'No description available.' }}</p>
            </div>
        </div>

        {{-- Store Info Section --}}
        <div class="store-section">
            <div class="store-header">
                <h3>Store Information</h3>
            </div>
            <div class="store-body">
                <div class="store-logo-sm">
                    @if($product->store->logo)
                        <img src="{{ asset('storage/' . $product->store->logo) }}" alt="{{ $product->store->name }}">
                    @else
                        <div class="store-logo-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="8" width="18" height="14" rx="2"/><path d="M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
                        </div>
                    @endif
                </div>
                <div class="store-details">
                    <h4><a href="{{ route('shop.store', $product->store->id) }}">{{ $product->store->name }}</a></h4>
                    <p>{{ Str::limit($product->store->description ?? 'Quality products and services', 100) }}</p>
                    <div class="store-stats">
                        <span>📦 {{ $product->store->products->count() }} products</span>
                        <span>⭐ 4.9 rating</span>
                        <span>📅 Since {{ $product->store->created_at->format('Y') }}</span>
                    </div>
                    <a href="{{ route('shop.store', $product->store->id) }}" class="store-link">Visit Store →</a>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="related-section">
            <div class="related-header">
                <h3>You May Also Like</h3>
                <span class="related-count">{{ $relatedProducts->count() }} items</span>
            </div>
            <div class="related-grid">
                @foreach($relatedProducts as $related)
                <div class="related-card">
                    <a href="{{ route('shop.product', $related->id) }}" class="related-link">
                        <div class="related-img">
                            <img src="{{ $related->first_image ?? asset('images/no-image.png') }}" 
                                 alt="{{ $related->name }}"
                                 onerror="this.src='{{ asset('images/no-image.png') }}'">
                        </div>
                        <div class="related-info">
                            <h4>{{ Str::limit($related->name, 35) }}</h4>
                            <div class="related-price">${{ number_format($related->price, 2) }}</div>
                            <div class="related-sold">{{ $related->sold_count ?? 0 }} sold</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@push('styles')
<style>
/* ============================================
   PRODUCT DETAIL PAGE — ALIBABA STYLE
   Primary Gold: #C6A43B | Dark: #1A2C3E
============================================ */

.product-page {
    background: #F5F7FA;
    min-height: calc(100vh - 64px);
    padding: 20px 0 48px;
}

.ali-container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Breadcrumb */
.ali-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #8A99B0;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.ali-breadcrumb a { color: #8A99B0; text-decoration: none; }
.ali-breadcrumb a:hover { color: #C6A43B; }
.ali-breadcrumb .cur { color: #1A2C3E; font-weight: 500; }

/* Product Layout */
.product-layout {
    display: flex;
    gap: 24px;
    margin-bottom: 24px;
}

/* Gallery */
.product-gallery {
    flex: 1;
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 20px;
}
.main-image-container {
    height: 380px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #F8FAFC;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 16px;
}
.main-image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
.thumbnail-list {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.thumbnail-item {
    width: 70px;
    height: 70px;
    border: 2px solid #E2E8F0;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s;
}
.thumbnail-item.active {
    border-color: #C6A43B;
}
.thumbnail-item:hover {
    border-color: #C6A43B;
}
.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info */
.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.product-info-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 24px;
}
.product-brand {
    margin-bottom: 12px;
}
.brand-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #C6A43B;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}
.brand-link:hover {
    text-decoration: underline;
}
.product-title {
    font-size: 22px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 10px 0;
    line-height: 1.3;
}
.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.stars {
    color: #C6A43B;
    font-size: 14px;
    letter-spacing: 1px;
}
.rating-text {
    font-size: 12px;
    color: #8A99B0;
}
.product-price {
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #E2E8F0;
}
.price-main {
    font-size: 28px;
    font-weight: 700;
    color: #C6A43B;
}
.price-unit {
    font-size: 13px;
    color: #8A99B0;
    margin-left: 4px;
}
.product-stats {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}
.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.stat-key {
    font-size: 13px;
    color: #8A99B0;
}
.stat-value {
    font-size: 13px;
    font-weight: 500;
    color: #1A2C3E;
}
.stat-value.in-stock {
    color: #10B981;
}
.stat-value.out-stock {
    color: #EF4444;
}
.product-quantity {
    margin-bottom: 20px;
}
.quantity-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #1A2C3E;
    margin-bottom: 10px;
}
.quantity-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}
.qty-btn {
    width: 34px;
    height: 34px;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.qty-btn:hover {
    border-color: #C6A43B;
    color: #C6A43B;
}
#qty-input {
    width: 60px;
    height: 34px;
    text-align: center;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    background: #fff;
}
.stock-warning {
    font-size: 11px;
    color: #8A99B0;
}
.product-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}
.btn-add-cart {
    flex: 1;
    padding: 12px 20px;
    background: #C6A43B;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background 0.2s;
}
.btn-add-cart:hover {
    background: #AD8E32;
}
.btn-view-cart {
    padding: 12px 24px;
    background: transparent;
    border: 1px solid #C6A43B;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    color: #C6A43B;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-view-cart:hover {
    background: rgba(198,164,59,0.1);
}
.out-of-stock-message {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    background: #FEF2F2;
    border-radius: 6px;
    color: #EF4444;
    font-size: 13px;
    margin-bottom: 16px;
}
.product-actions-secondary {
    display: flex;
    gap: 12px;
}
.btn-message, .btn-wishlist {
    flex: 1;
    padding: 10px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #5A6E85;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-message:hover, .btn-wishlist:hover {
    border-color: #C6A43B;
    color: #C6A43B;
}

/* Trade Card */
.trade-card {
    background: linear-gradient(135deg, #FEF8E8, #FDF4DC);
    border: 1px solid #E8D5A0;
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.trade-text strong {
    display: block;
    font-size: 12px;
    color: #C6A43B;
    margin-bottom: 2px;
}
.trade-text span {
    font-size: 11px;
    color: #8A99B0;
}

/* Description Section */
.description-section {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    margin-bottom: 24px;
    overflow: hidden;
}
.description-header {
    background: #F8FAFC;
    padding: 14px 20px;
    border-bottom: 1px solid #E2E8F0;
}
.description-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}
.description-body {
    padding: 20px;
}
.description-body p {
    font-size: 13px;
    color: #5A6E85;
    line-height: 1.6;
    margin: 0;
}

/* Store Section */
.store-section {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    margin-bottom: 24px;
    overflow: hidden;
}
.store-header {
    background: #F8FAFC;
    padding: 14px 20px;
    border-bottom: 1px solid #E2E8F0;
}
.store-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}
.store-body {
    display: flex;
    gap: 20px;
    padding: 20px;
}
.store-logo-sm img {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
}
.store-logo-placeholder {
    width: 64px;
    height: 64px;
    background: #F0F2F5;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.store-logo-placeholder svg {
    stroke: #8A99B0;
}
.store-details {
    flex: 1;
}
.store-details h4 {
    font-size: 15px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 6px 0;
}
.store-details h4 a {
    color: #1A2C3E;
    text-decoration: none;
}
.store-details h4 a:hover {
    color: #C6A43B;
}
.store-details p {
    font-size: 12px;
    color: #8A99B0;
    margin: 0 0 10px 0;
    line-height: 1.5;
}
.store-stats {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
}
.store-stats span {
    font-size: 11px;
    color: #8A99B0;
}
.store-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #C6A43B;
    text-decoration: none;
}
.store-link:hover {
    text-decoration: underline;
}

/* Related Products */
.related-section {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    overflow: hidden;
}
.related-header {
    background: #F8FAFC;
    padding: 14px 20px;
    border-bottom: 1px solid #E2E8F0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.related-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}
.related-count {
    font-size: 12px;
    color: #8A99B0;
    background: #F0F2F5;
    padding: 3px 10px;
    border-radius: 20px;
}
.related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: #E2E8F0;
}
.related-card {
    background: #fff;
    transition: all 0.2s;
}
.related-card:hover {
    background: #FEF8E8;
}
.related-link {
    text-decoration: none;
    display: block;
    padding: 16px;
}
.related-img {
    height: 140px;
    background: #F8FAFC;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 12px;
}
.related-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.related-info h4 {
    font-size: 13px;
    font-weight: 500;
    color: #1A2C3E;
    margin: 0 0 6px 0;
    line-height: 1.4;
}
.related-price {
    font-size: 15px;
    font-weight: 700;
    color: #C6A43B;
    margin-bottom: 4px;
}
.related-sold {
    font-size: 11px;
    color: #8A99B0;
}

/* Responsive */
@media (max-width: 900px) {
    .product-layout {
        flex-direction: column;
    }
    .related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 600px) {
    .related-grid {
        grid-template-columns: 1fr;
    }
    .store-body {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .store-stats {
        justify-content: center;
    }
    .product-actions, .product-actions-secondary {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Quantity selector
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    const qtyInput = document.getElementById('qty-input');
    const cartQuantity = document.getElementById('cartQuantity');
    const maxStock = {{ $product->quantity }};

    function updateQuantity(value) {
        let newValue = value;
        if (newValue < 1) newValue = 1;
        if (newValue > maxStock) newValue = maxStock;
        qtyInput.value = newValue;
        if (cartQuantity) cartQuantity.value = newValue;
    }

    if (qtyMinus) {
        qtyMinus.addEventListener('click', () => {
            updateQuantity(parseInt(qtyInput.value) - 1);
        });
    }
    if (qtyPlus) {
        qtyPlus.addEventListener('click', () => {
            updateQuantity(parseInt(qtyInput.value) + 1);
        });
    }

    // Thumbnail image change
    function changeImage(element, src) {
        document.getElementById('main-image').src = src;
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
    }
</script>
@endpush
@endsection