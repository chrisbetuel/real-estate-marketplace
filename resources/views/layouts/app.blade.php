<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BuildConnect - Professional Marketplace')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Google Maps -->
    <script loading="async" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') ?? '' }}&libraries=places"></script>

    
    <style>
        /* BuildConnect Brand Colors */
        :root {
            --brand-dark: #0F172A;
            --brand-gold: #C9A53B;
            --brand-gold-light: #d9b854;
            --brand-gold-dark: #b8932a;
            --white: #FFFFFF;
            --gray-50: #F8FAFC;
            --gray-100: #F1F5F9;
            --gray-200: #E2E8F0;
            --gray-300: #CBD5E1;
            --gray-400: #94A3B8;
            --gray-500: #64748B;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1E293B;
            --gray-900: #0F172A;
            --success: #059669;
            --danger: #DC2626;
            --warning: #D97706;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-700);
            padding-top: 0;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Adjust for landing page - no navbar padding */
        @if(request()->routeIs('home'))
        body {
            padding-top: 0 !important;
            background: var(--gray-50);
        }
        @endif
        
        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--brand-dark);
            margin-bottom: 1rem;
        }
        
        /* Navbar */
        .navbar {
            background: var(--white);
            padding: 0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .navbar-container {
            padding: 0 40px;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--brand-dark) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .brand-logo {
            height: 38px;
            width: auto;
        }
        
        .navbar-brand span {
            color: var(--brand-gold);
        }
        
        .nav-link {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--gray-600) !important;
            padding: 24px 18px !important;
            transition: color 0.2s ease;
        }
        
        .nav-link:hover {
            color: var(--brand-gold) !important;
        }
        
        .nav-link.active {
            color: var(--brand-gold) !important;
            position: relative;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 18px;
            right: 18px;
            height: 2px;
            background: var(--brand-gold);
        }
        
        /* Buttons */
        .btn-outline {
            background: transparent;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            padding: 8px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .btn-outline:hover {
            border-color: var(--brand-gold);
            color: var(--brand-gold);
        }
        
        .btn-primary-custom {
            background: var(--brand-gold);
            border: none;
            color: var(--brand-dark);
            padding: 8px 28px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .btn-primary-custom:hover {
            background: var(--brand-gold-dark);
            transform: translateY(-1px);
        }
        
        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-left: 20px;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 10px;
            transition: background 0.2s;
            text-decoration: none;
        }
        
        .user-dropdown:hover {
            background: var(--gray-100);
        }
        
        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid var(--brand-gold);
        }
        
        .user-name {
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--gray-700);
        }
        
        .dropdown-icon {
            font-size: 0.7rem;
            color: var(--gray-500);
        }
        
        /* Dropdown */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08);
            padding: 8px 0;
            margin-top: 12px;
            min-width: 200px;
        }
        
        .dropdown-item {
            padding: 8px 20px;
            font-size: 0.85rem;
            color: var(--gray-700);
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: var(--gray-50);
            color: var(--brand-gold);
            padding-left: 24px;
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 10px;
            color: var(--gray-500);
        }
        
        /* Cards */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            transition: all 0.2s ease;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        
        .card:hover {
            box-shadow: 0 8px 20px -6px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--brand-dark);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Badges */
        .badge {
            padding: 4px 10px;
            font-weight: 500;
            font-size: 0.7rem;
            border-radius: 20px;
        }
        
        .badge-success {
            background: #ECFDF5;
            color: var(--success);
        }
        
        .badge-warning {
            background: #FFFBEB;
            color: var(--warning);
        }
        
        .badge-gold {
            background: rgba(201, 165, 59, 0.1);
            color: var(--brand-gold);
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
        }
        
        .alert-success {
            background: #ECFDF5;
            color: var(--success);
            border-left: 3px solid var(--success);
        }
        
        .alert-danger {
            background: #FEF2F2;
            color: var(--danger);
            border-left: 3px solid var(--danger);
        }
        
        /* Pagination */
        .pagination {
            gap: 6px;
        }
        
        .page-link {
            border: 1px solid var(--gray-200);
            padding: 8px 14px;
            color: var(--gray-600);
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            background: var(--white);
        }
        
        .page-link:hover {
            background: var(--gray-50);
            border-color: var(--brand-gold);
            color: var(--brand-gold);
        }
        
        .active .page-link {
            background: var(--brand-gold);
            border-color: var(--brand-gold);
            color: var(--brand-dark);
        }
        
        /* Forms */
        .form-control, .form-select {
            border: 1px solid var(--gray-300);
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            background: var(--white);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-gold);
            box-shadow: 0 0 0 3px rgba(201, 165, 59, 0.1);
            outline: none;
        }
        
        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }
        
        /* Footer Styles */
        .footer {
            background: var(--brand-dark);
            padding: 48px 0 32px;
            margin-top: 80px;
        }
        
        .footer-logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--white);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-logo span {
            color: var(--brand-gold);
        }
        
        .footer-logo img {
            height: 32px;
            width: auto;
        }
        
        .footer-text {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
        }
        
        .footer-products h6 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--brand-gold);
            margin-bottom: 12px;
        }
        
        .product-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .product-list li {
            margin-bottom: 8px;
        }
        
        .product-list a {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .product-list a:hover {
            color: var(--brand-gold);
        }
        
        .footer-links h5 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--white);
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer-links a:hover {
            color: var(--brand-gold);
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.6);
            border-radius: 8px;
            margin-right: 8px;
            transition: all 0.2s;
        }
        
        .social-links a:hover {
            background: var(--brand-gold);
            color: var(--brand-dark);
        }
        
        .contact-info p {
            margin-bottom: 8px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
        }
        
        .contact-info i {
            width: 20px;
            color: var(--brand-gold);
            margin-right: 8px;
        }
        
        .contact-info a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .contact-info a:hover {
            color: var(--brand-gold);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 24px;
            margin-top: 32px;
            text-align: center;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .navbar-container {
                padding: 0 20px;
            }
            
            .nav-link {
                padding: 12px 20px !important;
            }
            
            .user-menu {
                margin: 15px 0;
                justify-content: center;
            }
        }
        
        /* Utilities */
        .bg-brand-dark { background: var(--brand-dark); }
        .bg-brand-gold { background: var(--brand-gold); }
        .text-brand-gold { color: var(--brand-gold); }
        .text-brand-dark { color: var(--brand-dark); }
        
    @stack('styles')
    </style>
</head>
<body @if(!request()->routeIs('home')) style="padding-top: 72px;" @endif>
@if(!request()->routeIs('home'))
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid navbar-container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('logo-white.png') }}" alt="BuildConnect" class="brand-logo">
                BuildConnect<span>.</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('professionals.*') ? 'active' : '' }}" href="{{ route('professionals.index') }}">Professionals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.stores') ? 'active' : '' }}" href="{{ route('shop.stores') }}">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.products') ? 'active' : '' }}" href="{{ route('shop.products') }}">Products</a>
                    </li>
                    
                    @auth
                        @if(Auth::user()->user_type == 'professional')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('professional.dashboard') ? 'active' : '' }}" href="{{ route('professional.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}" title="Messages">
                                    <i class="fas fa-sms me-1"></i>
                                </a>
                            </li>
                        @elseif(Auth::user()->user_type == 'client')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}" title="Messages">
                                    <i class="fas fa-sms me-1"></i>
                                </a>
                            </li>
                        @elseif(Auth::user()->user_type == 'store_owner')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('store-owner.dashboard') ? 'active' : '' }}" href="{{ route('store-owner.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                @auth
                    <div class="user-menu">
                        <div class="dropdown">
                            <a class="user-dropdown dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->profile_image_url }}" class="user-avatar" alt="{{ Auth::user()->name }}">
                                <span class="user-name d-none d-lg-inline">{{ Str::limit(Auth::user()->name, 14) }}</span>
                                <i class="fas fa-chevron-down dropdown-icon"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user"></i> Profile
                                </a></li>
                                @if(Auth::user()->user_type == 'professional')
                                    <li><a class="dropdown-item" href="{{ route('professional.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('professional.bids') }}">
                                        <i class="fas fa-gavel"></i> My Bids
                                    </a></li>
                                @elseif(Auth::user()->user_type == 'client')
                                    <li><a class="dropdown-item" href="{{ route('client.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('client.jobs') }}">
                                        <i class="fas fa-briefcase"></i> My Jobs
                                    </a></li>
                                @elseif(Auth::user()->user_type == 'store_owner')
                                    <li><a class="dropdown-item" href="{{ route('store-owner.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('store-owner.products') }}">
                                        <i class="fas fa-box"></i> My Products
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Sign out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn-outline">Sign in</a>
                        <a href="{{ route('register') }}" class="btn-primary-custom">Get started</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
@endif


    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success fade show sticky-top" role="alert" style="z-index: 1020;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fs-5"></i>
                        <div>
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger fade show sticky-top" role="alert" style="z-index: 1020;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3 fs-5"></i>
                        <div>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Updated Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Column 1: BuildConnect Products -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="footer-logo">
                        <img src="{{ asset('logo-white.png') }}" alt="BuildConnect">
                        BuildConnect<span>.</span>
                    </div>
                    <p class="footer-text">Connecting professionals with clients for real estate projects.</p>
                    <div class="footer-products mt-3">
                        <h6>Our Products</h6>
                        <ul class="product-list">
                            <li><a href="{{ route('professionals.index') }}">Professionals</a></li>
                            <li><a href="{{ route('shop.stores') }}">Stores</a></li>
                            <li><a href="{{ route('shop.products') }}">Products</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Column 2: Company -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h5>Company</h5>
                        <ul>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('our-story') }}">Our Story</a></li>
                            <li><a href="{{ route('how-it-works') }}">How It Works</a></li>
                            <li><a href="{{ route('team') }}">Our Team</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Column 3: Legal -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h5>Legal</h5>
                        <ul>
                            <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('copyright') }}">Copyright Policy</a></li>
                            <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Column 4: Connect -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h5>Connect With Us</h5>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="contact-info mt-3">
                            <p><i class="fas fa-envelope"></i> <a href="mailto:hello@buildconnect.com">hello@buildconnect.com</a></p>
                            <p><i class="fas fa-phone"></i> <a href="tel:+255123456789">+255 123 456 789</a></p>
                            <p><i class="fas fa-map-marker-alt"></i> Dar es Salaam, Tanzania</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} <span>BuildConnect</span>. All rights reserved. Building better connections in real estate.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 10) {
                    $('.navbar').css('box-shadow', '0 2px 8px rgba(0,0,0,0.04)');
                } else {
                    $('.navbar').css('box-shadow', '0 1px 2px rgba(0,0,0,0.02)');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>