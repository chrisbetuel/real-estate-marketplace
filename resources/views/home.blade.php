@extends('layouts.app')

@section('title', 'BuildConnect - Professional Marketplace')

@section('content')
<!-- Hero Section with Moving Background -->
<section class="hero-section">
    <div class="hero-background">
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80');"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1600566752355-35792bedcfea?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge animate-fadeInDown">
                <i class="fas fa-star"></i> Trusted by 10,000+ professionals
            </div>
            <img src="{{ asset('logo-white.png') }}" alt="BuildConnect" class="hero-logo animate-fadeInUp" style="max-height: 80px; width: auto;">
            <h1 class="hero-title animate-fadeInUp">Welcome to <span>BuildConnect</span></h1>
            <p class="hero-subtitle animate-fadeInUp delay-1">Connect with professionals for your real estate projects</p>
            
            <div class="hero-buttons animate-fadeInUp delay-2">
                @guest
                    <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">
                        <i class="fas fa-rocket me-2"></i>Get Started
                    </a>
                    <a href="{{ route('login') }}" class="btn-hero btn-hero-outline">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @else
                    <a href="{{ route('jobs.create') }}" class="btn-hero btn-hero-primary">
                        <i class="fas fa-plus-circle me-2"></i>Post a Job
                    </a>
                    <a href="{{ route('jobs.index') }}" class="btn-hero btn-hero-outline">
                        <i class="fas fa-search me-2"></i>Browse Jobs
                    </a>
                @endguest
            </div>
        </div>
    </div>
    
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,170.7C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="search-card">
            <div class="search-header">
                <i class="fas fa-search"></i>
                <h3>Find Your Perfect Professional</h3>
                <p>Search by service, category, or location</p>
            </div>
            <form action="{{ route('search.jobs') }}" method="GET">
                <div class="search-form">
                    <div class="search-input-group">
                        <i class="fas fa-briefcase"></i>
                        <input type="text" name="keyword" placeholder="What service do you need?">
                    </div>
                    <div class="search-input-group">
                        <i class="fas fa-tag"></i>
                        <select name="category">
                            <option value="">All Categories</option>
                            <option value="Engineer">Engineer</option>
                            <option value="Architect">Architect</option>
                            <option value="Electrician">Electrician</option>
                            <option value="Plumber">Plumber</option>
                            <option value="Carpenter">Carpenter</option>
                        </select>
                    </div>
                    <div class="search-input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="location" placeholder="Location">
                    </div>
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search me-2"></i>Find Professionals
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Service Ecosystem Section with Modal Popup -->
<section class="ecosystem-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">End-to-End Solutions</div>
            <h2>Service <span>Ecosystem</span></h2>
            <p>Complete professional services across your property lifecycle</p>
            <div class="header-line"></div>
        </div>

        <!-- Ecosystem Navigation Cards -->
        <div class="ecosystem-grid" id="ecosystemGrid">
            @php
                $stages = [
                    ['id' => 'planning', 'name' => 'Planning & Design', 'icon' => 'fas fa-drafting-compass', 'description' => 'Architects, designers, structural engineers', 'color' => '#c9a53b'],
                    ['id' => 'legal', 'name' => 'Legal & Compliance', 'icon' => 'fas fa-gavel', 'description' => 'Lawyers, surveyors, permit experts', 'color' => '#10b981'],
                    ['id' => 'finance', 'name' => 'Finance & Investment', 'icon' => 'fas fa-chart-line', 'description' => 'Advisors, mortgage brokers', 'color' => '#3b82f6'],
                    ['id' => 'construction', 'name' => 'Construction & Build', 'icon' => 'fas fa-hard-hat', 'description' => 'Contractors, project managers', 'color' => '#ef4444'],
                    ['id' => 'technical', 'name' => 'MEP & Technical', 'icon' => 'fas fa-bolt', 'description' => 'Electricians, plumbers, HVAC', 'color' => '#f59e0b'],
                    ['id' => 'finishing', 'name' => 'Finishing & Interiors', 'icon' => 'fas fa-paint-roller', 'description' => 'Painters, carpenters, decorators', 'color' => '#8b5cf6'],
                    ['id' => 'management', 'name' => 'Property Management', 'icon' => 'fas fa-building', 'description' => 'Property managers, leasing agents', 'color' => '#ec489a'],
                    ['id' => 'inspection', 'name' => 'Inspection & Audit', 'icon' => 'fas fa-clipboard-list', 'description' => 'Building inspectors, energy auditors', 'color' => '#14b8a6'],
                    ['id' => 'renovation', 'name' => 'Renovation & Restoration', 'icon' => 'fas fa-tools', 'description' => 'Renovation specialists, restorers', 'color' => '#6366f1'],
                ];
            @endphp
            @foreach($stages as $stage)
                <div class="ecosystem-card" data-stage="{{ $stage['id'] }}" data-stage-name="{{ $stage['name'] }}" data-stage-icon="{{ $stage['icon'] }}" data-stage-color="{{ $stage['color'] }}">
                    <div class="card-icon" style="background: {{ $stage['color'] }}20;">
                        <i class="{{ $stage['icon'] }}" style="color: {{ $stage['color'] }};"></i>
                    </div>
                    <div class="card-content">
                        <h4>{{ $stage['name'] }}</h4>
                        <p>{{ $stage['description'] }}</p>
                    </div>
                    <div class="card-count">
                        <span class="count" id="count-{{ $stage['id'] }}">0</span>
                        <span class="label">professionals</span>
                    </div>
                    <div class="card-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Professionals Modal - Two Step Selection -->
<div id="professionalsModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-users" id="modalIcon"></i>
                <div>
                    <h2 id="modalStageTitle">Professionals</h2>
                    <p class="modal-subtitle" id="modalSubtitle">Select a professional type to view available experts</p>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Step 1: Professional Types Selection -->
        <div class="modal-step" id="stepProfessionTypes">
            <div class="step-indicator">
                <span class="step-badge active">1</span>
                <span class="step-label">Select Profession</span>
                <span class="step-line"></span>
                <span class="step-badge">2</span>
                <span class="step-label">View Professionals</span>
            </div>
            <div class="profession-types-grid" id="professionTypesGrid">
                <div class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading professional types...</p>
                </div>
            </div>
        </div>
        
        <!-- Step 2: Professionals List -->
        <div class="modal-step" id="stepProfessionalsList" style="display: none;">
            <div class="step-indicator">
                <span class="step-badge completed">1</span>
                <span class="step-label">Select Profession</span>
                <span class="step-line"></span>
                <span class="step-badge active">2</span>
                <span class="step-label">View Professionals</span>
            </div>
            <div class="back-button" onclick="goBackToTypes()">
                <i class="fas fa-arrow-left"></i> Back to all professions
            </div>
            <div class="selected-profession-header" id="selectedProfessionHeader">
                <i class="fas fa-briefcase" id="selectedProfessionIcon"></i>
                <h3 id="selectedProfessionName"></h3>
                <span class="professional-count" id="selectedProfessionCount"></span>
            </div>
            <div class="professionals-grid-container" id="professionalsGridContainer">
                <div class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading professionals...</p>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button class="modal-footer-btn" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Simple Process</div>
            <h2>How <span>It Works</span></h2>
            <p>Get started in 4 easy steps</p>
            <div class="header-line"></div>
        </div>
        
        <div class="steps-container">
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h4>Create Account</h4>
                    <p>Sign up as a client or professional in minutes</p>
                </div>
                <div class="step-connector">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Find or Post</h4>
                    <p>Browse jobs or post your requirements</p>
                </div>
                <div class="step-connector">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Connect & Agree</h4>
                    <p>Communicate and agree on terms</p>
                </div>
                <div class="step-connector">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>Complete Project</h4>
                    <p>Work together and get paid securely</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-wrapper">
    <div class="container">
        <div class="cta-section">
            <div class="cta-content">
                <h2 class="cta-title">Ready to start your next project?</h2>
                <p class="cta-text">Join thousands of professionals and clients already using BuildConnect</p>
                <div class="cta-buttons">
                    @guest
                        <a href="{{ route('register') }}" class="btn-cta btn-cta-primary">
                            <i class="fas fa-user-plus me-2"></i>Sign Up Now
                        </a>
                        <a href="{{ route('login') }}" class="btn-cta btn-cta-outline">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @else
                        <a href="{{ route('jobs.create') }}" class="btn-cta btn-cta-primary">
                            <i class="fas fa-plus-circle me-2"></i>Post a Job
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn-cta btn-cta-outline">
                            <i class="fas fa-search me-2"></i>Browse Jobs
                        </a>
                    @endguest
                </div>
            </div>
            <div class="cta-stats">
                <div class="stat-item">
                    <div class="stat-number">10k+</div>
                    <div class="stat-label">Active Professionals</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5k+</div>
                    <div class="stat-label">Completed Projects</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* ========================================
       GLOBAL STYLES & VARIABLES
    ======================================== */
    :root {
        --brand-gold: #c9a53b;
        --brand-gold-dark: #b38f2e;
        --brand-gold-light: #e6c46e;
        --brand-dark: #0f172a;
        --brand-dark-soft: #1e293b;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-500: #64748b;
        --gray-700: #334155;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
        --shadow-md: 0 8px 20px rgba(0,0,0,0.08);
        --shadow-lg: 0 20px 40px rgba(0,0,0,0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hero, Search, How It Works, CTA styles (same as before - kept concise) */
    .hero-section { position: relative; min-height: 90vh; display: flex; align-items: center; overflow: hidden; }
    .hero-background { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
    .hero-background .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; opacity: 0; animation: slideShow 28s infinite; }
    .hero-background .slide:nth-child(1) { animation-delay: 0s; }
    .hero-background .slide:nth-child(2) { animation-delay: 7s; }
    .hero-background .slide:nth-child(3) { animation-delay: 14s; }
    .hero-background .slide:nth-child(4) { animation-delay: 21s; }
    @keyframes slideShow { 0% { opacity: 0; } 8% { opacity: 1; } 25% { opacity: 1; } 33% { opacity: 0; } 100% { opacity: 0; } }
    .hero-content { position: relative; z-index: 2; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(20px); border-radius: 32px; padding: 56px 48px; max-width: 700px; margin: 0 auto; text-align: center; box-shadow: var(--shadow-lg); border: 1px solid rgba(201, 165, 59, 0.2); }
    .hero-badge { display: inline-block; background: rgba(201, 165, 59, 0.2); backdrop-filter: blur(10px); padding: 8px 20px; border-radius: 40px; font-size: 0.85rem; margin-bottom: 24px; color: var(--brand-gold); }
    .hero-logo { max-height: 80px; width: auto; margin-bottom: 16px; }
    .hero-title { font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: white; margin-bottom: 16px; }
    .hero-title span { color: var(--brand-gold); }
    .hero-subtitle { color: rgba(255,255,255,0.95); font-size: 1.2rem; margin-bottom: 32px; }
    .btn-hero { padding: 14px 36px; border-radius: 50px; font-size: 1rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 12px; transition: var(--transition); }
    .btn-hero-primary { background: var(--brand-gold); color: var(--brand-dark); }
    .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(201, 165, 59, 0.3); background: var(--brand-gold-light); }
    .btn-hero-outline { background: transparent; border: 2px solid var(--brand-gold); color: white; }
    .btn-hero-outline:hover { background: var(--brand-gold); color: var(--brand-dark); transform: translateY(-2px); }
    .hero-wave { position: absolute; bottom: 0; left: 0; width: 100%; line-height: 0; }
    .hero-wave svg { width: 100%; height: 80px; }
    .animate-fadeInDown { animation: fadeInDown 0.8s ease; }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.2s; animation-fill-mode: forwards; }
    .delay-2 { animation-delay: 0.4s; animation-fill-mode: forwards; }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    
    .search-section { margin-top: -60px; position: relative; z-index: 10; padding-bottom: 60px; }
    .search-card { background: white; border-radius: 28px; padding: 32px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200); }
    .search-header { text-align: center; margin-bottom: 24px; }
    .search-header i { font-size: 2rem; color: var(--brand-gold); margin-bottom: 12px; }
    .search-header h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 8px; }
    .search-form { display: flex; gap: 16px; flex-wrap: wrap; }
    .search-input-group { flex: 1; position: relative; }
    .search-input-group i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--brand-gold); }
    .search-input-group input, .search-input-group select { width: 100%; padding: 14px 16px 14px 44px; border: 1px solid var(--gray-300); border-radius: 60px; transition: var(--transition); }
    .btn-search { padding: 14px 32px; background: var(--brand-gold); color: var(--brand-dark); border: none; border-radius: 60px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: var(--transition); }
    .btn-search:hover { background: var(--brand-gold-dark); transform: translateY(-2px); }
    
    .ecosystem-section { padding: 60px 0; background: var(--gray-50); }
    .section-header { text-align: center; margin-bottom: 48px; }
    .section-badge { display: inline-block; background: rgba(201, 165, 59, 0.1); color: var(--brand-gold); padding: 6px 16px; border-radius: 40px; font-size: 0.8rem; margin-bottom: 16px; }
    .section-header h2 { font-size: 2rem; font-weight: 700; margin-bottom: 12px; }
    .section-header h2 span { color: var(--brand-gold); }
    .header-line { width: 60px; height: 3px; background: var(--brand-gold); margin: 16px auto 0; border-radius: 3px; }
    
    .ecosystem-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
    .ecosystem-card { background: white; border-radius: 24px; padding: 24px; cursor: pointer; transition: var(--transition); border: 1px solid var(--gray-200); display: flex; align-items: center; gap: 18px; }
    .ecosystem-card:hover { transform: translateY(-6px); border-color: var(--brand-gold); box-shadow: var(--shadow-lg); }
    .card-icon { width: 56px; height: 56px; border-radius: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: var(--transition); }
    .card-icon i { font-size: 1.6rem; transition: var(--transition); }
    .card-content { flex: 1; }
    .card-content h4 { font-size: 1rem; font-weight: 700; margin-bottom: 4px; }
    .card-content p { font-size: 0.75rem; color: var(--gray-500); margin: 0; }
    .card-count { text-align: right; }
    .card-count .count { font-size: 1.2rem; font-weight: 800; color: var(--brand-gold); display: block; }
    .card-count .label { font-size: 0.65rem; color: var(--gray-500); }
    .card-arrow { opacity: 0; transition: var(--transition); color: var(--brand-gold); }
    .ecosystem-card:hover .card-arrow { opacity: 1; transform: translateX(6px); }
    
    /* Modal Styles - Two Step */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); display: none; align-items: center; justify-content: center; z-index: 10000; animation: fadeIn 0.25s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .modal-container { background: white; width: 90%; max-width: 1000px; max-height: 85vh; border-radius: 32px; overflow: hidden; animation: slideUp 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1); box-shadow: 0 30px 50px rgba(0,0,0,0.3); display: flex; flex-direction: column; }
    @keyframes slideUp { from { transform: translateY(40px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 24px 28px; border-bottom: 2px solid var(--gray-200); background: white; }
    .modal-title { display: flex; align-items: center; gap: 16px; }
    .modal-title i { font-size: 1.8rem; background: rgba(201, 165, 59, 0.1); padding: 12px; border-radius: 16px; color: var(--brand-gold); }
    .modal-title h2 { font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--brand-dark); }
    .modal-subtitle { font-size: 0.8rem; color: var(--gray-500); margin: 4px 0 0 0; }
    .modal-close { background: var(--gray-100); border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; color: var(--gray-500); }
    .modal-close:hover { background: var(--gray-200); transform: rotate(90deg); }
    .modal-step { flex: 1; overflow-y: auto; padding: 28px; }
    .modal-step::-webkit-scrollbar { width: 6px; }
    .modal-step::-webkit-scrollbar-track { background: var(--gray-200); border-radius: 3px; }
    .modal-step::-webkit-scrollbar-thumb { background: var(--brand-gold); border-radius: 3px; }
    .modal-footer { padding: 16px 28px; border-top: 1px solid var(--gray-200); display: flex; justify-content: flex-end; }
    .modal-footer-btn { padding: 10px 24px; background: var(--gray-100); border: none; border-radius: 40px; cursor: pointer; transition: var(--transition); color: var(--gray-700); font-weight: 500; }
    .modal-footer-btn:hover { background: var(--gray-200); }
    
    /* Step Indicator */
    .step-indicator { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 32px; padding: 16px; background: var(--gray-50); border-radius: 60px; }
    .step-badge { width: 32px; height: 32px; border-radius: 50%; background: var(--gray-300); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.9rem; transition: var(--transition); }
    .step-badge.active { background: var(--brand-gold); color: var(--brand-dark); }
    .step-badge.completed { background: #10b981; color: white; }
    .step-label { font-size: 0.8rem; color: var(--gray-500); font-weight: 500; }
    .step-line { width: 40px; height: 2px; background: var(--gray-300); }
    
    /* Professional Types Grid */
    .profession-types-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .profession-type-card { background: white; border: 2px solid var(--gray-200); border-radius: 20px; padding: 24px; cursor: pointer; transition: var(--transition); text-align: center; }
    .profession-type-card:hover { border-color: var(--brand-gold); transform: translateY(-4px); box-shadow: var(--shadow-md); }
    .profession-type-icon { width: 70px; height: 70px; background: rgba(201, 165, 59, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .profession-type-icon i { font-size: 2rem; color: var(--brand-gold); }
    .profession-type-card h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; }
    .profession-type-card p { font-size: 0.8rem; color: var(--gray-500); margin-bottom: 12px; }
    .profession-type-count { display: inline-block; background: var(--gray-100); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; color: var(--brand-gold); }
    
    /* Back Button */
    .back-button { display: inline-flex; align-items: center; gap: 8px; background: var(--gray-100); padding: 8px 16px; border-radius: 40px; cursor: pointer; transition: var(--transition); margin-bottom: 20px; font-size: 0.85rem; font-weight: 500; color: var(--gray-700); width: fit-content; }
    .back-button:hover { background: var(--gray-200); transform: translateX(-4px); }
    
    /* Selected Profession Header */
    .selected-profession-header { display: flex; align-items: center; gap: 16px; padding: 20px; background: linear-gradient(135deg, var(--gray-50) 0%, white 100%); border-radius: 20px; margin-bottom: 24px; border: 1px solid var(--gray-200); }
    .selected-profession-header i { font-size: 2rem; background: rgba(201, 165, 59, 0.1); padding: 14px; border-radius: 18px; color: var(--brand-gold); }
    .selected-profession-header h3 { font-size: 1.3rem; font-weight: 700; margin: 0; }
    .professional-count { background: var(--brand-gold); color: var(--brand-dark); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    
    /* Professionals Grid */
    .professionals-grid-container { display: flex; flex-direction: column; gap: 16px; }
    .professionals-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 18px; }
    .professional-card { display: flex; align-items: center; gap: 16px; padding: 18px; border: 1px solid var(--gray-200); border-radius: 20px; text-decoration: none; background: white; transition: var(--transition); }
    .professional-card:hover { border-color: var(--brand-gold); transform: translateY(-3px); box-shadow: var(--shadow-sm); }
    .pro-avatar img { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid var(--brand-gold); }
    .pro-info { flex: 1; }
    .pro-info h5 { font-size: 1rem; font-weight: 700; margin: 0 0 4px 0; color: var(--brand-dark); }
    .pro-profession { font-size: 0.75rem; color: var(--brand-gold); font-weight: 500; margin-bottom: 6px; }
    .pro-rating { display: flex; align-items: center; gap: 6px; font-size: 0.7rem; color: var(--gray-500); }
    .pro-rating .stars i { font-size: 0.65rem; color: #fbbf24; margin-right: 1px; }
    .pro-link { background: var(--brand-gold); color: var(--brand-dark); padding: 6px 14px; border-radius: 30px; font-size: 0.7rem; font-weight: 600; text-decoration: none; transition: var(--transition); white-space: nowrap; }
    .pro-link:hover { background: var(--brand-gold-dark); transform: translateY(-1px); }
    
    .loading-state { text-align: center; padding: 60px 20px; }
    .loading-state i { font-size: 2.5rem; color: var(--brand-gold); margin-bottom: 16px; }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 3rem; color: var(--gray-300); margin-bottom: 16px; }
    
    .how-it-works { padding: 70px 0; background: white; }
    .steps-container { overflow-x: auto; }
    .steps-grid { display: flex; justify-content: center; align-items: center; gap: 0; min-width: 800px; }
    .step-card { text-align: center; padding: 32px 24px; background: white; border-radius: 24px; border: 1px solid var(--gray-200); flex: 1; transition: var(--transition); }
    .step-card:hover { transform: translateY(-4px); border-color: var(--brand-gold); }
    .step-number { width: 48px; height: 48px; background: var(--brand-gold); color: var(--brand-dark); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; }
    .step-icon i { font-size: 2rem; color: var(--brand-gold); margin-bottom: 16px; display: block; }
    .step-connector { width: 60px; text-align: center; color: var(--brand-gold); font-size: 1.5rem; }
    .cta-wrapper { padding: 40px 0 70px; }
    .cta-section { background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-dark-soft) 100%); border-radius: 48px; padding: 56px 48px; position: relative; overflow: hidden; }
    .cta-content { text-align: center; position: relative; z-index: 1; }
    .cta-title { color: white; font-size: 2rem; font-weight: 800; margin-bottom: 16px; }
    .btn-cta { padding: 12px 32px; border-radius: 40px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: var(--transition); }
    .btn-cta-primary { background: var(--brand-gold); color: var(--brand-dark); }
    .btn-cta-outline { background: transparent; border: 2px solid var(--brand-gold); color: white; }
    .cta-stats { display: flex; justify-content: center; gap: 56px; margin-top: 48px; flex-wrap: wrap; }
    .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--brand-gold); }
    
    @media (max-width: 768px) {
        .ecosystem-grid { grid-template-columns: 1fr; }
        .profession-types-grid { grid-template-columns: 1fr; }
        .professionals-grid { grid-template-columns: 1fr; }
        .professional-card { flex-direction: column; text-align: center; }
        .step-indicator { flex-wrap: wrap; }
        .step-line { display: none; }
        .steps-grid { flex-direction: column; min-width: auto; }
        .step-connector { transform: rotate(90deg); margin: 12px 0; }
        .modal-container { width: 95%; margin: 16px; }
    }
</style>
@endpush

@push('scripts')
<script>
// ========================================
// PROFESSIONALS DATA - Organized by Ecosystem and Profession Type
// ========================================
const professionalsData = {
    planning: {
        name: "Planning & Design",
        icon: "fas fa-drafting-compass",
        professionals: [
            { id: 1, name: 'Emma Wright', profession: 'Architect', avatar: 'https://randomuser.me/api/portraits/women/68.jpg', rating: 4.9, reviews: 142, bio: 'Award-winning architect specializing in modern residential design' },
            { id: 2, name: 'Liam Chen', profession: 'Structural Engineer', avatar: 'https://randomuser.me/api/portraits/men/32.jpg', rating: 4.8, reviews: 97, bio: 'Expert in structural analysis and seismic design' },
            { id: 3, name: 'Sophia Rossi', profession: 'Interior Designer', avatar: 'https://randomuser.me/api/portraits/women/44.jpg', rating: 4.9, reviews: 211, bio: 'Creating beautiful, functional spaces that inspire' },
            { id: 4, name: 'James O\'Connor', profession: 'Landscape Architect', avatar: 'https://randomuser.me/api/portraits/men/46.jpg', rating: 4.7, reviews: 63, bio: 'Sustainable landscape design specialist' }
        ]
    },
    legal: {
        name: "Legal & Compliance",
        icon: "fas fa-gavel",
        professionals: [
            { id: 5, name: 'Olivia Bennett', profession: 'Real Estate Lawyer', avatar: 'https://randomuser.me/api/portraits/women/22.jpg', rating: 5.0, reviews: 88, bio: 'Expert in property transactions and contract law' },
            { id: 6, name: 'Noah Carter', profession: 'Land Surveyor', avatar: 'https://randomuser.me/api/portraits/men/41.jpg', rating: 4.6, reviews: 54, bio: 'Precision land surveying and boundary determination' }
        ]
    },
    finance: {
        name: "Finance & Investment",
        icon: "fas fa-chart-line",
        professionals: [
            { id: 7, name: 'Ava Martinez', profession: 'Investment Advisor', avatar: 'https://randomuser.me/api/portraits/women/90.jpg', rating: 4.8, reviews: 112, bio: 'Real estate investment strategy specialist' },
            { id: 8, name: 'Ethan Kim', profession: 'Mortgage Broker', avatar: 'https://randomuser.me/api/portraits/men/52.jpg', rating: 4.7, reviews: 79, bio: 'Finding the best financing solutions for your project' }
        ]
    },
    construction: {
        name: "Construction & Build",
        icon: "fas fa-hard-hat",
        professionals: [
            { id: 9, name: 'Mason Brooks', profession: 'General Contractor', avatar: 'https://randomuser.me/api/portraits/men/22.jpg', rating: 4.9, reviews: 324, bio: 'Full-service construction management' },
            { id: 10, name: 'Isabella Reed', profession: 'Project Manager', avatar: 'https://randomuser.me/api/portraits/women/33.jpg', rating: 4.9, reviews: 156, bio: 'Certified PMP with 15+ years experience' }
        ]
    },
    technical: {
        name: "MEP & Technical",
        icon: "fas fa-bolt",
        professionals: [
            { id: 11, name: 'Lucas Gray', profession: 'Electrician', avatar: 'https://randomuser.me/api/portraits/men/75.jpg', rating: 4.8, reviews: 234, bio: 'Licensed master electrician' },
            { id: 12, name: 'Mia Foster', profession: 'Plumber', avatar: 'https://randomuser.me/api/portraits/women/12.jpg', rating: 4.7, reviews: 189, bio: 'Emergency plumbing and installation expert' },
            { id: 13, name: 'Elijah Scott', profession: 'HVAC Technician', avatar: 'https://randomuser.me/api/portraits/men/8.jpg', rating: 4.9, reviews: 102, bio: 'Heating and cooling systems specialist' }
        ]
    },
    finishing: {
        name: "Finishing & Interiors",
        icon: "fas fa-paint-roller",
        professionals: [
            { id: 14, name: 'Charlotte Wood', profession: 'Painter', avatar: 'https://randomuser.me/api/portraits/women/59.jpg', rating: 4.6, reviews: 78, bio: 'Residential and commercial painting expert' },
            { id: 15, name: 'Benjamin Flores', profession: 'Carpenter', avatar: 'https://randomuser.me/api/portraits/men/64.jpg', rating: 4.8, reviews: 143, bio: 'Custom woodworking and cabinetry' }
        ]
    },
    management: {
        name: "Property Management",
        icon: "fas fa-building",
        professionals: [
            { id: 16, name: 'Amelia Hill', profession: 'Property Manager', avatar: 'https://randomuser.me/api/portraits/women/80.jpg', rating: 4.9, reviews: 201, bio: 'Full-service property management solutions' }
        ]
    },
    inspection: {
        name: "Inspection & Audit",
        icon: "fas fa-clipboard-list",
        professionals: [
            { id: 17, name: 'William Adams', profession: 'Building Inspector', avatar: 'https://randomuser.me/api/portraits/men/91.jpg', rating: 4.8, reviews: 115, bio: 'Certified building code inspector' }
        ]
    },
    renovation: {
        name: "Renovation & Restoration",
        icon: "fas fa-tools",
        professionals: [
            { id: 18, name: 'Harper Evans', profession: 'Renovation Specialist', avatar: 'https://randomuser.me/api/portraits/women/47.jpg', rating: 4.7, reviews: 167, bio: 'Complete home renovation and remodeling' },
            { id: 19, name: 'Henry Ward', profession: 'Restoration Expert', avatar: 'https://randomuser.me/api/portraits/men/11.jpg', rating: 4.9, reviews: 92, bio: 'Historic restoration and preservation' }
        ]
    }
};

// Get unique profession types from each ecosystem
function getProfessionTypesForEcosystem(stageId) {
    const ecosystem = professionalsData[stageId];
    if (!ecosystem) return [];
    
    const professionMap = new Map();
    ecosystem.professionals.forEach(pro => {
        if (!professionMap.has(pro.profession)) {
            professionMap.set(pro.profession, []);
        }
        professionMap.get(pro.profession).push(pro);
    });
    
    return Array.from(professionMap.entries()).map(([name, pros]) => ({
        name: name,
        count: pros.length,
        professionals: pros
    }));
}

// Update professional counts on ecosystem cards
function updateProfessionalCounts() {
    const stages = ['planning', 'legal', 'finance', 'construction', 'technical', 'finishing', 'management', 'inspection', 'renovation'];
    stages.forEach(stage => {
        const count = professionalsData[stage] ? professionalsData[stage].professionals.length : 0;
        const countElement = document.getElementById(`count-${stage}`);
        if (countElement) countElement.textContent = count;
    });
}

// Modal elements
const modal = document.getElementById('professionalsModal');
const modalIcon = document.getElementById('modalIcon');
const modalStageTitle = document.getElementById('modalStageTitle');
const modalSubtitle = document.getElementById('modalSubtitle');
const stepProfessionTypes = document.getElementById('stepProfessionTypes');
const stepProfessionalsList = document.getElementById('stepProfessionalsList');
const professionTypesGrid = document.getElementById('professionTypesGrid');
const professionalsGridContainer = document.getElementById('professionalsGridContainer');
const selectedProfessionName = document.getElementById('selectedProfessionName');
const selectedProfessionIcon = document.getElementById('selectedProfessionIcon');
const selectedProfessionCount = document.getElementById('selectedProfessionCount');

let currentStageId = null;
let currentStageData = null;
let currentProfessionTypes = [];

function closeModal() {
    modal.style.display = 'none';
    // Reset to step 1
    stepProfessionTypes.style.display = 'block';
    stepProfessionalsList.style.display = 'none';
}

window.closeModal = closeModal;

// Go back to profession types selection
function goBackToTypes() {
    stepProfessionalsList.style.display = 'none';
    stepProfessionTypes.style.display = 'block';
    // Refresh the types grid in case something changed
    renderProfessionTypes();
}

window.goBackToTypes = goBackToTypes;

// Render profession type cards (Step 1)
function renderProfessionTypes() {
    if (!currentProfessionTypes.length) {
        professionTypesGrid.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h4>No professionals available</h4>
                <p>This ecosystem category doesn't have any professionals yet</p>
            </div>
        `;
        return;
    }
    
    professionTypesGrid.innerHTML = currentProfessionTypes.map(type => `
        <div class="profession-type-card" onclick="selectProfessionType('${type.name.replace(/'/g, "\\'")}')">
            <div class="profession-type-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <h4>${type.name}</h4>
            <p>Specialized professionals in ${type.name.toLowerCase()}</p>
            <span class="profession-type-count">${type.count} professional${type.count > 1 ? 's' : ''}</span>
        </div>
    `).join('');
}

// Select a profession type and show professionals (Step 2)
function selectProfessionType(professionName) {
    const selectedType = currentProfessionTypes.find(t => t.name === professionName);
    if (!selectedType) return;
    
    // Update header
    selectedProfessionName.textContent = selectedType.name;
    selectedProfessionIcon.className = 'fas fa-briefcase';
    selectedProfessionCount.textContent = `${selectedType.count} professional${selectedType.count > 1 ? 's' : ''}`;
    
    // Render professionals grid
    professionalsGridContainer.innerHTML = `
        <div class="professionals-grid">
            ${selectedType.professionals.map(pro => `
                <a href="/professionals/${pro.id}" class="professional-card">
                    <div class="pro-avatar">
                        <img src="${pro.avatar}" alt="${pro.name}">
                    </div>
                    <div class="pro-info">
                        <h5>${pro.name}</h5>
                        <div class="pro-profession">${pro.profession}</div>
                        <div class="pro-rating">
                            <div class="stars">${renderStars(pro.rating)}</div>
                            <span>(${pro.reviews} reviews)</span>
                        </div>
                        <p style="font-size: 0.7rem; color: var(--gray-500); margin-top: 6px;">${pro.bio || ''}</p>
                    </div>
                    <div class="pro-link">
                        View Profile <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            `).join('')}
        </div>
    `;
    
    // Switch to step 2
    stepProfessionTypes.style.display = 'none';
    stepProfessionalsList.style.display = 'block';
}

window.selectProfessionType = selectProfessionType;

// Render stars helper
function renderStars(rating) {
    let stars = '';
    const fullStars = Math.floor(rating);
    const hasHalf = rating - fullStars >= 0.5;
    
    for (let i = 1; i <= 5; i++) {
        if (i <= fullStars) stars += '<i class="fas fa-star"></i>';
        else if (i === fullStars + 1 && hasHalf) stars += '<i class="fas fa-star-half-alt"></i>';
        else stars += '<i class="far fa-star"></i>';
    }
    return stars;
}

// Open modal for selected ecosystem
function openModalForEcosystem(stageId, stageName, stageIcon, stageColor) {
    currentStageId = stageId;
    currentStageData = professionalsData[stageId];
    
    // Set modal header
    modalIcon.className = stageIcon;
    modalIcon.style.color = stageColor;
    modalStageTitle.textContent = stageName;
    modalSubtitle.textContent = `Select a professional type to find the right expert for your ${stageName.toLowerCase()} needs`;
    
    // Get profession types for this ecosystem
    currentProfessionTypes = getProfessionTypesForEcosystem(stageId);
    
    // Reset to step 1
    stepProfessionTypes.style.display = 'block';
    stepProfessionalsList.style.display = 'none';
    
    // Show loading state
    professionTypesGrid.innerHTML = `
        <div class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Loading professional types...</p>
        </div>
    `;
    
    modal.style.display = 'flex';
    
    // Simulate loading for smooth UX
    setTimeout(() => {
        renderProfessionTypes();
    }, 100);
}

// Add click handlers to ecosystem cards
document.addEventListener('DOMContentLoaded', function() {
    updateProfessionalCounts();
    
    const ecosystemCards = document.querySelectorAll('.ecosystem-card');
    ecosystemCards.forEach(card => {
        card.addEventListener('click', function() {
            const stageId = this.dataset.stage;
            const stageName = this.dataset.stageName;
            const stageIcon = this.dataset.stageIcon;
            const stageColor = this.dataset.stageColor;
            
            ecosystemCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            
            openModalForEcosystem(stageId, stageName, stageIcon, stageColor);
        });
    });
    
    // Close modal on overlay click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') closeModal();
    });
});
</script>
@endpush
@endsection