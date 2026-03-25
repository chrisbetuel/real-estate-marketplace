{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Oweru Real Estate')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-dark: #0F172A;
            --soft-white: #F8F8F9;
            --gold-accent: #C9A53B;
            --light-grey: #E5E5E5;
            --medium-grey: #D9D9D9;
        }
        
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f4f6f9;
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--primary-dark);
            color: var(--soft-white);
            position: fixed;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            color: var(--soft-white);
            margin: 10px 0 0;
        }
        
        .sidebar-header span {
            color: var(--gold-accent);
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: var(--soft-white);
            text-decoration: none;
            transition: all 0.3s;
            opacity: 0.8;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            opacity: 1;
            border-left-color: var(--gold-accent);
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: var(--gold-accent);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .navbar-top {
            background: var(--soft-white);
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border-radius: 10px;
        }
        
        .page-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: var(--soft-white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: none;
            margin-bottom: 20px;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(15,23,42,0.15);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            line-height: 60px;
            background: rgba(201,165,59,0.1);
            color: var(--gold-accent);
            border-radius: 50%;
            text-align: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stats-number {
            font-family: 'Nunito', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .table-custom {
            background: var(--soft-white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .table-custom thead {
            background: var(--primary-dark);
            color: var(--soft-white);
        }
        
        .table-custom th {
            font-family: 'Nunito', sans-serif;
            font-weight: 600;
            padding: 15px;
        }
        
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .btn-gold {
            background: var(--gold-accent);
            color: var(--primary-dark);
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201,165,59,0.3);
            background: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        .badge-gold {
            background: rgba(201,165,59,0.1);
            color: var(--gold-accent);
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                position: fixed;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('logo-white.png') }}" alt="Oweru" style="height: 60px; width: auto;">
            <h3>Oweru<span>.</span></h3>
            <p style="font-size: 0.8rem; opacity: 0.7;">Admin Panel</p>
        </div>
        
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stores.index') }}" class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                        <i class="fas fa-store"></i> Store Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.locations.index') }}" class="{{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i> Locations
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jobs.index') }}" class="{{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i> Jobs
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-cube"></i> Products
                    </a>
                </li>
                <li class="mt-4 pt-4 border-top border-secondary">
                    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none text-white opacity-75 hover-opacity-100" style="padding: 12px 20px; width: 100%; text-align: left;">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="navbar-top d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-link d-md-none" id="menuToggle" style="color: var(--primary-dark);">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <span class="ms-2">Welcome, {{ Auth::guard('admin')->user()->name }}</span>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle text-dark" type="button" data-bs-toggle="dropdown">
                        <img src="{{ Auth::guard('admin')->user()->profile_image_url }}" 
                             alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; border: 2px solid var(--gold-accent);">
                        <span class="ms-2 d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <h1 class="page-title">@yield('page-title')</h1>
            
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.style.width === '250px' || sidebar.style.width === '') {
                sidebar.style.width = '0';
            } else {
                sidebar.style.width = '250px';
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>