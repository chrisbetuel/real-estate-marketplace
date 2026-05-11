@extends('layouts.app')

@section('title', $store->name . ' - BuildConnect')

@section('content')
<div class="ali-page">
    <div class="ali-container">

        {{-- Breadcrumb --}}
        <div class="ali-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('shop.stores') }}">Stores</a>
            <span>/</span>
            <span class="cur">{{ $store->name }}</span>
        </div>

        {{-- Store Header --}}
        <div class="ali-store-header">
            <div class="ali-header-top">
                <div class="ali-logo-wrap">
                    <div class="ali-logo">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}">
                        @else
                            <span class="ali-logo-initials">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="ali-verified-ring">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ali-header-info">
                    <div class="ali-store-name-main">{{ $store->name }}</div>
                    <div class="ali-header-badges">
                        <span class="ali-badge ali-badge-verified">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Verified Store
                        </span>
                        <span class="ali-badge ali-badge-gold">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Gold Member
                        </span>
                        <span class="ali-badge ali-badge-trade">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Trade Assurance
                        </span>
                    </div>
                    <div class="ali-header-actions">
                        @if($store->email)
                            <a href="mailto:{{ $store->email }}" class="ali-btn-contact">✉ Contact Supplier</a>
                        @endif
                        <button class="ali-btn-follow" onclick="alert('Store followed')">+ Follow</button>
                    </div>
                </div>
                <div class="ali-header-stats">
                    <div class="ali-hstat">
                        <div class="ali-hstat-num">{{ $store->products->count() }}</div>
                        <div class="ali-hstat-label">Products</div>
                    </div>
                    <div class="ali-hstat">
                        <div class="ali-hstat-num">{{ $store->orders_count ?? 0 }}</div>
                        <div class="ali-hstat-label">Orders</div>
                    </div>
                    <div class="ali-hstat">
                        <div class="ali-hstat-num">{{ $store->created_at->format('Y') }}</div>
                        <div class="ali-hstat-label">Since</div>
                    </div>
                </div>
            </div>
            <div class="ali-header-tabs">
                <div class="ali-tab active" data-tab="products">Products</div>
                <div class="ali-tab" data-tab="profile">Company Profile</div>
                <div class="ali-tab" data-tab="contact">Contact</div>
            </div>
        </div>

        {{-- Main Layout --}}
        <div class="ali-layout">

            {{-- LEFT SIDEBAR --}}
            <div class="ali-sidebar">

                {{-- Contact Section --}}
                <div class="ali-sidebar-section">
                    <div class="ali-sidebar-title">Contact Now</div>
                    <div class="ali-sidebar-body">
                        <div class="ali-contact-row">
                            <div class="ali-contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <div>
                                <div class="ali-contact-label">Email</div>
                                <div class="ali-contact-val"><a href="mailto:{{ $store->email }}">{{ $store->email }}</a></div>
                            </div>
                        </div>
                        @if($store->phone)
                        <div class="ali-contact-row">
                            <div class="ali-contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div>
                                <div class="ali-contact-label">Phone</div>
                                <div class="ali-contact-val"><a href="tel:{{ $store->phone }}">{{ $store->phone }}</a></div>
                            </div>
                        </div>
                        @endif
                        @if($store->address)
                        <div class="ali-contact-row">
                            <div class="ali-contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div>
                                <div class="ali-contact-label">Address</div>
                                <div class="ali-contact-val">{{ $store->address }}{{ $store->city ? ', ' . $store->city : '' }}</div>
                            </div>
                        </div>
                        @endif
                        <a href="mailto:{{ $store->email }}" class="ali-btn-inquiry">Send Inquiry</a>
                    </div>
                </div>

                {{-- Company Profile Sidebar --}}
                <div class="ali-sidebar-section">
                    <div class="ali-sidebar-title">Company Profile</div>
                    <div class="ali-sidebar-body">
                        <div class="ali-stat-row">
                            <span class="ali-stat-key">Total Products</span>
                            <span class="ali-stat-val ali-gold">{{ $store->products->count() }}</span>
                        </div>
                        <div class="ali-stat-row">
                            <span class="ali-stat-key">Orders Fulfilled</span>
                            <span class="ali-stat-val">{{ $store->orders_count ?? 0 }}</span>
                        </div>
                        <div class="ali-stat-row">
                            <span class="ali-stat-key">Member Since</span>
                            <span class="ali-stat-val">{{ $store->created_at->format('M Y') }}</span>
                        </div>
                        <div class="ali-stat-row">
                            <span class="ali-stat-key">Response Rate</span>
                            <span class="ali-stat-val ali-gold">98% (&lt;4h)</span>
                        </div>
                    </div>
                </div>

                {{-- Certifications (if any) --}}
                @if(($store->certifications ?? []) && count($store->certifications) > 0)
                <div class="ali-sidebar-section">
                    <div class="ali-sidebar-title">Certifications</div>
                    <div class="ali-sidebar-body">
                        @foreach($store->certifications as $cert)
                        <div class="ali-cert-row">
                            <div class="ali-cert-dot"></div>
                            <span class="ali-cert-name">{{ $cert->name ?? $cert }}</span>
                            <span class="ali-cert-year">{{ $cert->year ?? '2024' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- RIGHT MAIN CONTENT --}}
            <div class="ali-main">

                {{-- Products Tab (Default Visible) --}}
                <div id="tab-products" class="ali-tab-content active">
                    {{-- Trade Assurance Banner --}}
                    <div class="ali-trade-banner">
                        <svg width="36" height="36" viewBox="0 0 40 40" fill="none">
                            <path d="M20 4L6 9v10c0 8.284 6.154 16.025 14 18 7.846-1.975 14-9.716 14-18V9L20 4z" fill="#FFF8F0" stroke="#C6A43B" stroke-width="1.5"/>
                            <path d="M14 20l4 4 8-8" stroke="#C6A43B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <strong>Trade Assurance Protected</strong>
                            <span>On-time shipment &amp; product quality guaranteed. Dispute resolution available.</span>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($store->description)
                    <div class="ali-desc-banner">
                        <div class="ali-desc-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <div class="ali-desc-text">
                            <h4>About {{ $store->name }}</h4>
                            <p>{{ $store->description }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Products Bar --}}
                    <div class="ali-products-bar">
                        <h3>All Products</h3>
                        <span class="ali-pcount">{{ $store->products->count() }} items</span>
                        <div class="ali-sort-wrap">
                            <select class="ali-sort-select" id="sortProducts">
                                <option value="">Sort: Best Match</option>
                                <option value="price_asc">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                            </select>
                        </div>
                    </div>

                    {{-- Products Grid --}}
                    @if($store->products->count() > 0)
                    <div class="ali-products-grid" id="productsGrid">
                        @foreach($store->products as $product)
                        <div class="ali-product-card" data-price="{{ $product->price ?? 0 }}" data-date="{{ $product->created_at->timestamp ?? 0 }}">
                            <a href="{{ route('shop.product', $product->id) }}" class="ali-product-link">
                                <div class="ali-product-img">
                                    <img src="{{ $product->first_image ?? asset('images/no-image.png') }}"
                                         alt="{{ $product->name }}"
                                         onerror="this.src='{{ asset('images/no-image.png') }}'">
                                    @if($product->quantity <= 0)
                                        <span class="ali-stock-badge ali-stock-out">Out of Stock</span>
                                    @elseif($product->quantity <= 5)
                                        <span class="ali-stock-badge ali-stock-low">Only {{ $product->quantity }} left</span>
                                    @endif
                                </div>
                                <div class="ali-product-body">
                                    <div class="ali-product-title">{{ Str::limit($product->name, 60) }}</div>
                                    <div class="ali-product-price-row">
                                        <span class="ali-price-main">${{ number_format($product->price ?? 0, 2) }}</span>
                                        <span class="ali-price-unit">/ piece</span>
                                    </div>
                                    <div class="ali-product-meta-row">
                                        <span class="ali-sold-info">{{ $product->sold_count ?? 0 }} sold</span>
                                        <span class="ali-stars">★★★★★</span>
                                    </div>
                                </div>
                            </a>
                            <div class="ali-product-actions">
                                <a href="{{ route('shop.product', $product->id) }}" class="ali-btn-details">Details</a>
                                @if($product->quantity > 0)
                                <form action="{{ route('shop.add-to-cart', $product->id) }}" method="POST" class="ali-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="ali-btn-cart">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                        Add to Cart
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="ali-empty">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.5"><rect x="3" y="8" width="18" height="14" rx="2"/><path d="M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
                        <h3>No Products Yet</h3>
                        <p>This store hasn't added any products yet.</p>
                    </div>
                    @endif
                </div>

                {{-- Company Profile Tab --}}
                <div id="tab-profile" class="ali-tab-content">
                    <div class="ali-profile-card">
                        <div class="ali-profile-header">
                            <h3>Company Overview</h3>
                        </div>
                        <div class="ali-profile-body">
                            <div class="ali-profile-row">
                                <span class="ali-profile-label">Company Name</span>
                                <span class="ali-profile-value">{{ $store->name }}</span>
                            </div>
                            <div class="ali-profile-row">
                                <span class="ali-profile-label">Business Type</span>
                                <span class="ali-profile-value">Distributor / Wholesaler</span>
                            </div>
                            <div class="ali-profile-row">
                                <span class="ali-profile-label">Year Established</span>
                                <span class="ali-profile-value">{{ $store->created_at->format('Y') }}</span>
                            </div>
                            <div class="ali-profile-row">
                                <span class="ali-profile-label">Location</span>
                                <span class="ali-profile-value">{{ $store->address ?? 'Not specified' }}{{ $store->city ? ', ' . $store->city : '' }}</span>
                            </div>
                            @if($store->description)
                            <div class="ali-profile-row">
                                <span class="ali-profile-label">Description</span>
                                <span class="ali-profile-value">{{ $store->description }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Contact Tab --}}
                <div id="tab-contact" class="ali-tab-content">
                    <div class="ali-contact-card">
                        <div class="ali-contact-card-header">
                            <h3>Contact Information</h3>
                        </div>
                        <div class="ali-contact-card-body">
                            <div class="ali-contact-card-row">
                                <div class="ali-contact-card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </div>
                                <div>
                                    <div class="ali-contact-card-label">Email</div>
                                    <div class="ali-contact-card-value"><a href="mailto:{{ $store->email }}">{{ $store->email }}</a></div>
                                </div>
                            </div>
                            @if($store->phone)
                            <div class="ali-contact-card-row">
                                <div class="ali-contact-card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div>
                                    <div class="ali-contact-card-label">Phone</div>
                                    <div class="ali-contact-card-value"><a href="tel:{{ $store->phone }}">{{ $store->phone }}</a></div>
                                </div>
                            </div>
                            @endif
                            @if($store->address)
                            <div class="ali-contact-card-row">
                                <div class="ali-contact-card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <div class="ali-contact-card-label">Address</div>
                                    <div class="ali-contact-card-value">{{ $store->address }}{{ $store->city ? ', ' . $store->city : '' }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="ali-contact-card-footer">
                            <a href="mailto:{{ $store->email }}" class="ali-btn-contact-large">Send Message</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ============================================
   STORE PAGE — ALIBABA STYLE WITH GOLD (#C6A43B)
   Primary Gold: #C6A43B | Dark: #1A2C3E
============================================ */

.ali-page {
    background: #F5F7FA;
    min-height: calc(100vh - 64px);
    padding: 16px 0 48px;
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
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.ali-breadcrumb a { color: #8A99B0; text-decoration: none; }
.ali-breadcrumb a:hover { color: #C6A43B; }
.ali-breadcrumb .cur { color: #1A2C3E; font-weight: 500; }

/* Store Header */
.ali-store-header {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    margin-bottom: 14px;
    overflow: hidden;
}
.ali-header-top {
    background: linear-gradient(135deg, #1A2C3E 0%, #243647 100%);
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}
.ali-logo-wrap { position: relative; flex-shrink: 0; }
.ali-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid rgba(198,164,59,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.ali-logo img { width: 100%; height: 100%; object-fit: cover; }
.ali-logo-initials { font-size: 24px; font-weight: 600; color: #C6A43B; }
.ali-verified-ring {
    position: absolute;
    bottom: -2px; right: -2px;
    width: 22px; height: 22px;
    background: #00A650;
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ali-verified-ring svg { width: 11px; height: 11px; }
.ali-header-info { flex: 1; min-width: 0; }
.ali-store-name-main {
    font-size: 20px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 8px;
}
.ali-header-badges { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
.ali-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 500;
}
.ali-badge svg { width: 10px; height: 10px; }
.ali-badge-verified { background: rgba(0,166,80,0.15); color: #4ADE80; border: 1px solid rgba(0,166,80,0.3); }
.ali-badge-gold { background: rgba(198,164,59,0.15); color: #C6A43B; border: 1px solid rgba(198,164,59,0.3); }
.ali-badge-trade { background: rgba(230,46,4,0.15); color: #FF8A7A; border: 1px solid rgba(230,46,4,0.3); }
.ali-header-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.ali-btn-contact {
    background: #C6A43B;
    color: #1A2C3E;
    border: none;
    padding: 9px 20px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s;
}
.ali-btn-contact:hover { background: #AD8E32; color: #1A2C3E; }
.ali-btn-follow {
    background: transparent;
    color: #fff;
    border: 1px solid rgba(255,255,255,0.4);
    padding: 9px 20px;
    border-radius: 4px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}
.ali-btn-follow:hover { border-color: #C6A43B; color: #C6A43B; }
.ali-header-stats { display: flex; gap: 24px; flex-shrink: 0; }
.ali-hstat { text-align: center; }
.ali-hstat-num { font-size: 20px; font-weight: 600; color: #C6A43B; }
.ali-hstat-label { font-size: 11px; color: #aaa; margin-top: 2px; }
.ali-header-tabs {
    display: flex;
    border-top: 1px solid #E2E8F0;
    background: #fff;
    overflow-x: auto;
}
.ali-tab {
    padding: 11px 20px;
    font-size: 13px;
    font-weight: 500;
    color: #8A99B0;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.15s;
    white-space: nowrap;
}
.ali-tab.active { color: #C6A43B; border-bottom-color: #C6A43B; }

/* Layout */
.ali-layout {
    display: flex;
    gap: 14px;
    align-items: flex-start;
}

/* Sidebar */
.ali-sidebar { width: 230px; flex-shrink: 0; }
.ali-sidebar-section {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    margin-bottom: 12px;
    overflow: hidden;
}
.ali-sidebar-title {
    background: #F8FAFC;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 600;
    color: #1A2C3E;
    border-bottom: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.ali-sidebar-title::before {
    content: '';
    width: 3px;
    height: 14px;
    background: #C6A43B;
    border-radius: 2px;
    display: inline-block;
}
.ali-sidebar-body { padding: 14px; }
.ali-contact-row {
    display: flex;
    gap: 10px;
    margin-bottom: 12px;
    align-items: flex-start;
}
.ali-contact-icon {
    width: 28px;
    height: 28px;
    background: #FEF8E8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ali-contact-icon svg { width: 13px; height: 13px; stroke: #C6A43B; }
.ali-contact-label { font-size: 11px; color: #8A99B0; margin-bottom: 2px; }
.ali-contact-val { font-size: 12px; font-weight: 500; color: #1A2C3E; word-break: break-all; }
.ali-contact-val a { color: #1A2C3E; text-decoration: none; }
.ali-contact-val a:hover { color: #C6A43B; }
.ali-btn-inquiry {
    display: block;
    width: 100%;
    background: #C6A43B;
    color: #1A2C3E;
    font-weight: 600;
    border: none;
    padding: 9px;
    border-radius: 4px;
    font-size: 13px;
    text-align: center;
    margin-top: 12px;
    text-decoration: none;
    transition: background 0.2s;
}
.ali-btn-inquiry:hover { background: #AD8E32; color: #1A2C3E; }
.ali-stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    border-bottom: 1px solid #F0F2F5;
    font-size: 12px;
}
.ali-stat-row:last-child { border-bottom: none; }
.ali-stat-key { color: #8A99B0; }
.ali-stat-val { font-weight: 500; color: #1A2C3E; }
.ali-stat-val.ali-gold { color: #C6A43B; }
.ali-cert-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 0;
    border-bottom: 1px solid #F0F2F5;
    font-size: 12px;
}
.ali-cert-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #C6A43B;
}
.ali-cert-name { flex: 1; color: #1A2C3E; }
.ali-cert-year { color: #8A99B0; font-size: 11px; }

/* Main Content */
.ali-main { flex: 1; min-width: 0; }
.ali-tab-content { display: none; }
.ali-tab-content.active { display: block; }

/* Trade Assurance */
.ali-trade-banner {
    background: linear-gradient(135deg, #FEF8E8, #FDF4DC);
    border: 1px solid #E8D5A0;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.ali-trade-banner strong { font-size: 12px; color: #C6A43B; display: block; margin-bottom: 2px; }
.ali-trade-banner span { font-size: 11px; color: #8A99B0; }

/* Description */
.ali-desc-banner {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 12px;
    display: flex;
    gap: 12px;
    align-items: flex-start;
}
.ali-desc-icon {
    width: 36px;
    height: 36px;
    background: #FEF8E8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ali-desc-icon svg { width: 16px; height: 16px; stroke: #C6A43B; }
.ali-desc-text h4 { font-size: 13px; font-weight: 600; color: #1A2C3E; margin: 0 0 4px; }
.ali-desc-text p { font-size: 12px; color: #8A99B0; line-height: 1.6; margin: 0; }

/* Products Bar */
.ali-products-bar {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 10px 16px;
    margin-bottom: 1px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.ali-products-bar h3 { font-size: 14px; font-weight: 600; color: #1A2C3E; margin: 0; }
.ali-pcount { background: #FEF8E8; color: #C6A43B; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: 600; }
.ali-sort-wrap { margin-left: auto; }
.ali-sort-select {
    border: 1px solid #E2E8F0;
    border-radius: 4px;
    padding: 5px 8px;
    font-size: 12px;
    color: #1A2C3E;
    background: #fff;
    cursor: pointer;
}

/* Products Grid */
.ali-products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: #E2E8F0;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    overflow: hidden;
}
.ali-product-card {
    background: #fff;
    transition: box-shadow 0.2s;
}
.ali-product-card:hover {
    z-index: 1;
    box-shadow: 0 2px 16px rgba(198,164,59,0.16);
    outline: 1.5px solid #C6A43B;
}
.ali-product-link { text-decoration: none; display: block; }
.ali-product-img {
    height: 185px;
    background: #F8FAFC;
    overflow: hidden;
    position: relative;
}
.ali-product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}
.ali-product-card:hover .ali-product-img img { transform: scale(1.06); }
.ali-stock-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
}
.ali-stock-out { background: rgba(0,0,0,0.65); color: #fff; }
.ali-stock-low { background: #FFF8E1; color: #E65100; border: 1px solid #FFCC80; }
.ali-product-body { padding: 10px 12px 6px; }
.ali-product-title {
    font-size: 12px;
    color: #1A2C3E;
    line-height: 1.45;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 35px;
}
.ali-product-price-row { display: flex; align-items: baseline; gap: 4px; margin-bottom: 4px; }
.ali-price-main { font-size: 17px; font-weight: 700; color: #C6A43B; }
.ali-price-unit { font-size: 11px; color: #8A99B0; }
.ali-product-meta-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px; }
.ali-sold-info { font-size: 11px; color: #8A99B0; }
.ali-stars { font-size: 11px; color: #C6A43B; }
.ali-product-actions { padding: 0 12px 12px; display: flex; gap: 6px; }
.ali-btn-details {
    flex: 1;
    padding: 7px 0;
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    color: #8A99B0;
    text-decoration: none;
    text-align: center;
    transition: all 0.15s;
}
.ali-btn-details:hover { border-color: #C6A43B; color: #C6A43B; }
.ali-cart-form { flex: 1; }
.ali-btn-cart {
    width: 100%;
    padding: 7px 0;
    background: #C6A43B;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    color: #1A2C3E;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: background 0.15s;
}
.ali-btn-cart:hover { background: #AD8E32; color: #1A2C3E; }
.ali-btn-cart svg { width: 12px; height: 12px; }

/* Profile Tab */
.ali-profile-card, .ali-contact-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    overflow: hidden;
}
.ali-profile-header, .ali-contact-card-header {
    background: #F8FAFC;
    padding: 14px 20px;
    border-bottom: 1px solid #E2E8F0;
}
.ali-profile-header h3, .ali-contact-card-header h3 { font-size: 14px; font-weight: 600; color: #1A2C3E; margin: 0; }
.ali-profile-body, .ali-contact-card-body { padding: 20px; }
.ali-profile-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #F0F2F5;
}
.ali-profile-row:last-child { border-bottom: none; }
.ali-profile-label {
    width: 140px;
    font-size: 12px;
    color: #8A99B0;
    flex-shrink: 0;
}
.ali-profile-value {
    flex: 1;
    font-size: 13px;
    color: #1A2C3E;
}
.ali-contact-card-row {
    display: flex;
    gap: 14px;
    margin-bottom: 20px;
    align-items: flex-start;
}
.ali-contact-card-icon {
    width: 40px;
    height: 40px;
    background: #FEF8E8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ali-contact-card-icon svg { width: 18px; height: 18px; stroke: #C6A43B; }
.ali-contact-card-label { font-size: 11px; color: #8A99B0; margin-bottom: 4px; }
.ali-contact-card-value { font-size: 14px; font-weight: 500; color: #1A2C3E; }
.ali-contact-card-value a { color: #1A2C3E; text-decoration: none; }
.ali-contact-card-value a:hover { color: #C6A43B; }
.ali-contact-card-footer { padding: 16px 20px; border-top: 1px solid #E2E8F0; }
.ali-btn-contact-large {
    display: inline-block;
    background: #C6A43B;
    color: #1A2C3E;
    font-weight: 600;
    border: none;
    padding: 10px 28px;
    border-radius: 4px;
    font-size: 13px;
    text-decoration: none;
    transition: background 0.2s;
}
.ali-btn-contact-large:hover { background: #AD8E32; color: #1A2C3E; }

/* Empty State */
.ali-empty {
    text-align: center;
    padding: 60px 24px;
    background: #fff;
    border-radius: 8px;
    border: 1px solid #E2E8F0;
}
.ali-empty h3 { font-size: 15px; font-weight: 500; color: #1A2C3E; margin: 12px 0 6px; }
.ali-empty p { font-size: 13px; color: #8A99B0; margin: 0; }

/* Responsive */
@media (max-width: 960px) {
    .ali-products-grid { grid-template-columns: repeat(2, 1fr); }
    .ali-header-stats { display: none; }
}
@media (max-width: 780px) {
    .ali-layout { flex-direction: column; }
    .ali-sidebar { width: 100%; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
@media (max-width: 560px) {
    .ali-sidebar { grid-template-columns: 1fr; }
    .ali-products-grid { grid-template-columns: repeat(2, 1fr); }
    .ali-header-top { flex-direction: column; text-align: center; }
    .ali-header-actions { justify-content: center; }
    .ali-header-badges { justify-content: center; }
}
@media (max-width: 380px) {
    .ali-products-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = document.querySelectorAll('.ali-tab');
    const contents = {
        products: document.getElementById('tab-products'),
        profile: document.getElementById('tab-profile'),
        contact: document.getElementById('tab-contact')
    };
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            Object.values(contents).forEach(content => {
                if (content) content.classList.remove('active');
            });
            if (contents[tabId]) contents[tabId].classList.add('active');
        });
    });
    
    // Product sorting
    const sortSelect = document.getElementById('sortProducts');
    const productsGrid = document.getElementById('productsGrid');
    
    if (sortSelect && productsGrid) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            let products = Array.from(productsGrid.children);
            
            if (sortValue === 'price_asc') {
                products.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
            } else if (sortValue === 'price_desc') {
                products.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
            } else if (sortValue === 'newest') {
                products.sort((a, b) => parseFloat(b.dataset.date) - parseFloat(a.dataset.date));
            } else {
                return;
            }
            
            products.forEach(product => productsGrid.appendChild(product));
        });
    }
});
</script>
@endpush
@endsection