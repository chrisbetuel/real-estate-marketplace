<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OWERU — BuildConnect | Construction Marketplace</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ============================================
   ALIBABA-STYLE DESIGN - PRESERVING ALL FUNCTIONALITY
   ============================================ */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', sans-serif;
  background: #ffffff;
  color: #1f2a3e;
  line-height: 1.5;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

/* Top Bar - Alibaba Trust Bar */
.top-bar {
  background: #f5f7fa;
  border-bottom: 1px solid #e4e7ed;
  font-size: 12px;
  padding: 8px 0;
  color: #6c757d;
}
.top-bar .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.top-links a {
  color: #6c757d;
  margin-left: 24px;
  text-decoration: none;
}
.top-links a:hover { color: gold; }
.top-links a.cta-link { color: gold; font-weight: 600; }

/* Header - Sticky */
.main-header {
  background: #ffffff;
  position: sticky;
  top: 0;
  z-index: 100;
  border-bottom: 1px solid #eef2f6;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}
.header-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 76px;
}

/* Logo */
.logo {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}
.logo-icon {
  width: 42px;
  height: 42px;
  background: #1e293b;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.logo-text h2 {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: -0.5px;
  color: #1e293b;
}
.logo-text span { color: gold; }
.logo-text p {
  font-size: 9px;
  color: #7e8c9a;
  letter-spacing: 1px;
  margin-top: 2px;
}

/* Search Box */
.search-wrapper {
  flex: 1;
  max-width: 520px;
  margin: 0 32px;
}
.search-box {
  display: flex;
  border: 2px solid gold;
  border-radius: 8px;
  overflow: hidden;
  background: white;
}
.search-box input {
  flex: 1;
  padding: 12px 18px;
  border: none;
  font-size: 14px;
  outline: none;
}
.search-box button {
  background: gold;
  border: none;
  padding: 0 28px;
  color: white;
  font-weight: 600;
  cursor: pointer;
  transition: 0.2s;
}
.search-box button:hover { background: gold; }

/* Header Actions */
.header-actions {
  display: flex;
  gap: 28px;
}
.action-item {
  text-align: center;
  font-size: 12px;
  color: #4b5563;
  text-decoration: none;
}
.action-item i {
  font-size: 20px;
  display: block;
  margin-bottom: 4px;
}
.action-item:hover { color: gold; }

/* Navigation Tabs */
.nav-cats {
  background: #ffffff;
  border-bottom: 1px solid #eef2f6;
}
.cat-links {
  display: flex;
  gap: 32px;
  padding: 12px 0;
  font-size: 14px;
  font-weight: 500;
  flex-wrap: wrap;
}
.cat-links a {
  text-decoration: none;
  color: #374151;
}
.cat-links a:hover, .cat-links a.active { color: gold; }

/* Hero Section - Alibaba Style */
.hero-section {
  background: linear-gradient(135deg, #fefaf5 0%, #ffffff 100%);
  padding: 40px 0;
  border-bottom: 1px solid #f0f2f5;
}
.hero-grid {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 32px;
  align-items: center;
}
.hero-left h1 {
  font-size: 36px;
  font-weight: 800;
  line-height: 1.2;
  margin-bottom: 16px;
  color: #1e293b;
}
.hero-left h1 span { color: gold; }
.hero-left p {
  color: #5a6874;
  margin-bottom: 24px;
  font-size: 15px;
}
.stats-group {
  display: flex;
  gap: 32px;
  margin: 24px 0;
}
.stat { text-align: left; }
.stat .number { font-size: 28px; font-weight: 800; color: #1e293b; }
.stat .label { font-size: 12px; color: #7e8c9a; }
.hero-search-form {
  display: flex;
  gap: 12px;
  margin: 24px 0;
  flex-wrap: wrap;
}
.hero-search-input {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 10px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 12px 16px;
}
.hero-search-input:focus-within { border-color: gold; }
.hero-search-input input {
  border: none;
  background: transparent;
  width: 100%;
  outline: none;
  font-size: 14px;
}
.hero-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 16px;
}
.hero-tags a {
  padding: 6px 16px;
  background: #f1f5f9;
  border-radius: 30px;
  font-size: 12px;
  text-decoration: none;
  color: #4b5563;
}
.hero-tags a:hover { background: gold; color: white; }

.hero-right {
  background: linear-gradient(135deg, #1e2a3a 0%, #0f172a 100%);
  border-radius: 20px;
  padding: 32px;
  color: white;
}
.hero-stats {
  display: flex;
  justify-content: space-between;
  margin-bottom: 24px;
}
.hero-stats .stat-item { text-align: center; }
.hero-stats .stat-val { font-size: 32px; font-weight: 800; color: gold; }
.hero-testimonial {
  border-top: 1px solid rgba(255,255,255,0.1);
  padding-top: 20px;
  margin-top: 10px;
}
.hero-testimonial p {
  font-style: italic;
  font-size: 14px;
  color: #cbd5e1;
}
.testi-author {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 16px;
}
.testi-author img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

/* Trust Bar */
.trust-bar {
  background: #f8fafc;
  padding: 16px 0;
  border-bottom: 1px solid #eef2f6;
}
.trust-list {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 24px;
}
.trust-list li {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  color: #5a6874;
}
.trust-list svg { width: 16px; stroke: gold; }

/* Section Styles */
.section { padding: 56px 0; border-bottom: 1px solid #edf2f7; }
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
}
.section-header h2 {
  font-size: 24px;
  font-weight: 700;
}
.section-header h2 em { color: gold; font-style: normal; }
.section-header a {
  color: gold;
  font-size: 13px;
  text-decoration: none;
  font-weight: 500;
}

/* Category Grid */
.category-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 16px;
}
.cat-card {
  background: white;
  border: 1px solid #eef2f6;
  border-radius: 12px;
  padding: 24px 12px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  color: inherit;
}
.cat-card:hover {
  border-color: gold;
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.cat-card i { font-size: 36px; color: gold; margin-bottom: 12px; display: block; }
.cat-card h4 { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
.cat-card p { font-size: 11px; color: #7e8c9a; }

/* Split Section */
.split-section {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.split-panel {
  padding: 64px 48px;
}
.light-panel { background: #fefcf9; }
.dark-panel { background: #1e293b; color: white; }
.split-panel h3 {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 16px;
}
.split-panel h3 em { color: gold; font-style: normal; }
.split-panel p { margin-bottom: 24px; line-height: 1.6; color: #5a6874; }
.dark-panel p { color: #94a3b8; }
.checklist {
  list-style: none;
  margin: 24px 0;
}
.checklist li {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
  font-size: 14px;
}
.check-icon svg { width: 16px; stroke: gold; stroke-width: 2.5; }

/* Pros Grid */
.pros-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.pro-card {
  border: 1px solid #eef2f6;
  border-radius: 12px;
  padding: 20px;
  background: white;
  transition: all 0.2s;
}
.pro-card:hover {
  border-color: gold;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.pro-header {
  display: flex;
  gap: 12px;
  align-items: center;
  margin-bottom: 16px;
}
.pro-avatar {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  object-fit: cover;
}
.pro-info h4 { font-size: 16px; font-weight: 700; }
.pro-title { font-size: 12px; color: gold; font-weight: 500; margin: 2px 0; }
.pro-rating { color: gold; font-size: 12px; }
.pro-details {
  font-size: 12px;
  color: #5a6874;
  margin: 12px 0;
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}
.btn-contact {
  width: 100%;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  padding: 8px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  text-align: center;
  display: block;
  text-decoration: none;
  color: #1f2937;
}
.btn-contact:hover { background: gold; color: white; border-color: gold; }

/* Steps */
.steps-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.step {
  text-align: center;
  padding: 24px;
}
.step-num {
  width: 48px;
  height: 48px;
  background: #fff3e8;
  color: gold;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 20px;
  margin-bottom: 16px;
}
.step h4 { font-size: 18px; margin-bottom: 8px; }
.step p { font-size: 13px; color: #5a6874; }

/* Testimonials */
.testi-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.testi-card {
  background: #fefcf9;
  padding: 24px;
  border-radius: 12px;
  border: 1px solid #f0f2f5;
}
.testi-text {
  font-size: 14px;
  color: #334155;
  margin-bottom: 16px;
  line-height: 1.6;
}

/* CTA Banner */
.cta-banner {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  padding: 64px 0;
  text-align: center;
}
.cta-banner h2 {
  color: white;
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 16px;
}
.cta-banner h2 em { color: gold; font-style: normal; }
.cta-banner p { color: #94a3b8; margin-bottom: 32px; }

/* Footer */
.footer {
  background: #1e293b;
  color: #9ca3af;
  padding: 56px 0 32px;
}
.footer-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 48px;
  margin-bottom: 48px;
}
.footer-col h5 {
  color: white;
  font-size: 14px;
  margin-bottom: 20px;
}
.footer-col a {
  display: block;
  color: #9ca3af;
  text-decoration: none;
  font-size: 13px;
  margin-bottom: 10px;
}
.footer-col a:hover { color: gold; }
.footer-bottom {
  border-top: 1px solid #334155;
  padding-top: 24px;
  text-align: center;
  font-size: 12px;
  display: flex;
  justify-content: space-between;
}

/* Modal (preserved from original) */
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  backdrop-filter: blur(4px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal__box {
  background: white;
  max-width: 500px;
  width: 90%;
  border-radius: 16px;
  overflow: hidden;
}
.modal__hd {
  padding: 20px 24px;
  border-bottom: 1px solid #eef2f6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.modal__close {
  cursor: pointer;
  font-size: 24px;
}
.modal__body { padding: 24px; }
.modal__ft {
  padding: 16px 24px;
  border-top: 1px solid #eef2f6;
  display: flex;
  justify-content: flex-end;
}

/* Responsive */
@media (max-width: 1024px) {
  .category-grid { grid-template-columns: repeat(3,1fr); }
  .pros-grid { grid-template-columns: repeat(2,1fr); }
  .hero-grid { grid-template-columns: 1fr; }
  .split-section { grid-template-columns: 1fr; }
  .steps-grid { grid-template-columns: 1fr; }
  .testi-grid { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 768px) {
  .header-inner { flex-wrap: wrap; height: auto; gap: 12px; padding: 12px 0; }
  .search-wrapper { margin: 0; order: 3; width: 100%; max-width: 100%; }
  .category-grid { grid-template-columns: repeat(2,1fr); }
  .pros-grid { grid-template-columns: 1fr; }
  .trust-list { justify-content: center; }
}
</style>
</head>
<body>

<!-- Top Bar - PRESERVED ORIGINAL LINKS -->
<div class="top-bar">
  <div class="container">
    <div><i class="fas fa-shield-alt"></i> Africa's Elite Construction Network — Active in 54 Countries</div>
    <div class="top-links">
      <a href="/login">Sign In</a>
      <a href="/register" class="cta-link">Apply as Professional →</a>
    </div>
  </div>
</div>

<!-- Main Header - PRESERVED ORIGINAL LINKS -->
<div class="main-header">
  <div class="container">
    <div class="header-inner">
      <a href="/" class="logo">
        <div class="logo-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="gold" stroke-width="2"><path d="M4 20 L8 8 L12 14 L16 9 L20 20"/></svg></div>
        <div class="logo-text"><h2>BUILD<span>Connect</span></h2><p>Construction freelancer</p></div>
      </a>
      <div class="search-wrapper">
        <div class="search-box">
          <input type="text" id="keywordInput" placeholder="Search professionals, services, or projects...">
          <button id="searchBtn"><i class="fas fa-search"></i> Search</button>
        </div>
      </div>
      <div class="header-actions">
        <a href="/jobs" class="action-item"><i class="fas fa-briefcase"></i> Find Work</a>
        <a href="#categories" class="action-item"><i class="fas fa-users"></i> Hire Talent</a>
        <a href="/register" class="action-item"><i class="fas fa-user-plus"></i> Get Started</a>
      </div>
    </div>
  </div>
</div>

<!-- Navigation - PRESERVED ORIGINAL LINKS -->
<div class="nav-cats">
  <div class="container">
    <div class="cat-links">
      <a href="/jobs" class="active">Find Work</a>
      <a href="#categories">Hire Talent</a>
      <a href="{{ route('pos.single-shop') }}">manage Single Shop</a>
      <a href="{{ route('pos.multi-shop') }}">manage Multi Shop</a>
      <a href="#">Why Oweru</a>
    </div>
  </div>
</div>

<!-- Hero Section - PRESERVED ORIGINAL FORM FUNCTIONALITY -->
<section class="hero-section">
  <div class="container">
    <div class="hero-grid">
      <div class="hero-left">
        <h1>Build <span>Connect</span><br></h1>
        <p>This system connects clients, professionals, and store owners in one platform. It enables clients to request services, professionals to offer their expertise, and stores to manage and deliver their products efficiently through a reliable digital system</p>
        <div class="stats-group">
          <div class="stat"><div class="number">10k+</div><div class="label">Vetted Professionals</div></div>
          <div class="stat"><div class="number">98%</div><div class="label">Match Success Rate</div></div>
          <div class="stat"><div class="number">48h</div><div class="label">Avg. Time to Hire</div></div>
        </div>
        <form id="heroSearchForm" action="/search/professionals" method="GET" class="hero-search-form">
          <div class="hero-search-input">
            <i class="fas fa-search"></i>
            <input type="text" name="keyword" placeholder="e.g. Structural Engineer...">
          </div>
          <div class="hero-search-input">
            <i class="fas fa-map-marker-alt"></i>
            <input type="text" name="location" placeholder="Enter location">
          </div>
          <button type="submit" class="search-box" style="border: none; background: gold; padding: 0 28px; border-radius: 8px; color: white; font-weight: 600;">Find Nearby →</button>
        </form>
        <div class="hero-tags">
          <span style="font-size:12px; color:#7e8c9a;">Popular:</span>
          <a href="/search?keyword=Architect">Architect</a>
          <a href="/search?keyword=Civil+Engineer">Civil Engineer</a>
          <a href="/search?keyword=Project+Manager">Project Manager</a>
          <a href="/search?keyword=Quantity+Surveyor">QS</a>
        </div>
      </div>
      <div class="hero-right">
        <div class="hero-stats">
          <div class="stat-item"><div class="stat-val">10k+</div><div>Professionals</div></div>
          <div class="stat-item"><div class="stat-val">98%</div><div>Success Rate</div></div>
          <div class="stat-item"><div class="stat-val">5k+</div><div>Projects</div></div>
        </div>
        <div class="hero-testimonial">
          <p>"Oweru connected us with a structural engineer in 2 days. It saved our entire project timeline."</p>
          <div class="testi-author">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sarah K.">
            <div><strong>Sarah K.</strong><br><span style="font-size:11px;">Project Director, Dangote Group</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Trust Bar -->
<div class="trust-bar">
  <div class="container">
    <ul class="trust-list">
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>Verified Credentials</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Secure Escrow Payments</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>2-Week Risk-Free Trial</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>24/7 Dedicated Support</li>
    </ul>
  </div>
</div>

<!-- Categories Section - PRESERVED ORIGINAL ID AND FUNCTIONALITY -->
<section class="section" id="categories">
  <div class="container">
    <div class="section-header">
      <h2>Browse by <em>Category</em></h2>
      <a href="/jobs">View all categories →</a>
    </div>
    <div class="category-grid" id="categoryGrid"></div>
  </div>
</section>

<!-- Split Section - PRESERVED ORIGINAL LINKS -->
<section class="split-section">
  <div class="split-panel light-panel">
    <h3>Hire the top 3% of Africa's <em>construction talent</em></h3>
    <p>Skip the noise. Work with architects, engineers, and managers who've passed our rigorous 5-step screening process.</p>
    <ul class="checklist">
      <li><div class="check-icon"><svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>No upfront recruiting fees</li>
      <li><div class="check-icon"><svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>2-week risk-free trial period</li>
      <li><div class="check-icon"><svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>Milestone-based secure payments</li>
    </ul>
    <a href="/register" class="btn-contact" style="width: auto; display: inline-block; padding: 12px 28px;">Hire a Professional →</a>
  </div>
  <div class="split-panel dark-panel">
    <h3>Join Africa's <em>elite</em> construction network</h3>
    <p>Apply to an exclusive community connecting Africa's best builders with high-value, long-term projects from top clients.</p>
    <ul class="checklist">
      <li><div class="check-icon"><svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>High-value project leads daily</li>
      <li><div class="check-icon"><svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>Guaranteed weekly payments</li>
      <li><div class="check-icon"><svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>Build your global portfolio</li>
    </ul>
    <a href="/jobs" class="btn-contact" style="width: auto; display: inline-block; padding: 12px 28px; background: gold; color: white;">Browse Open Roles →</a>
  </div>
</section>

<!-- Featured Professionals - PRESERVED ORIGINAL MODAL FUNCTIONALITY -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <h2>Featured <em>Professionals</em></h2>
      <a href="/jobs">View all →</a>
    </div>
    <div class="pros-grid" id="prosGrid"></div>
  </div>
</section>

<!-- How It Works -->
<section class="section" style="background: #fafcff;">
  <div class="container">
    <div class="section-header" style="justify-content: center; text-align: center; display: block;">
      <h2>How <em>Oweru</em> Works</h2>
      <p style="color: #5a6874; margin-top: 8px;">From posting to payment — everything you need to manage construction projects successfully.</p>
    </div>
    <div class="steps-grid">
      <div class="step"><div class="step-num">1</div><h4>Post Your Requirements</h4><p>Describe your construction needs. Our AI matches you with top-qualified professionals.</p></div>
      <div class="step"><div class="step-num">2</div><h4>Review Curated Matches</h4><p>Compare profiles, portfolios, and reviews. Interview directly on the platform.</p></div>
      <div class="step"><div class="step-num">3</div><h4>Collaborate & Pay Securely</h4><p>Use built-in tools for contracts, milestones, and secure escrow.</p></div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <h2>Trusted by Africa's <em>Leading Builders</em></h2>
      <a href="#">Read more stories →</a>
    </div>
    <div class="testi-grid" id="testimonialsGrid"></div>
  </div>
</section>

<!-- CTA Banner -->
<div class="cta-banner">
  <div class="container">
    <h2>Build Africa's future, <em>starting today.</em></h2>
    <p>Join the network trusted by the continent's largest infrastructure projects and leading construction firms across 54 nations.</p>
    <div style="display: flex; gap: 16px; justify-content: center;">
      <a href="/register" class="btn-contact" style="background: gold; color: white; width: auto; padding: 12px 32px;">Get Started Free →</a>
      <a href="#" class="btn-contact" style="background: transparent; border: 1px solid gold; color: white; width: auto; padding: 12px 32px;">Talk to Sales</a>
    </div>
    <p style="margin-top: 24px; font-size: 12px;">Free to get started · No credit card required</p>
  </div>
</div>

<!-- Footer - PRESERVED ORIGINAL LINKS -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <a href="/" class="logo" style="margin-bottom: 16px; display: inline-flex;">
          <div class="logo-icon" style="background: gold;"><svg width="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M4 20 L8 8 L12 14 L16 9 L20 20"/></svg></div>
          <div class="logo-text"><h2 style="color:white;">OWERU<span>Build</span></h2></div>
        </a>
        <p style="font-size: 13px;">Connecting Africa's best construction professionals with leading projects across the continent.</p>
      </div>
      <div class="footer-col"><h5>For Clients</h5><a href="/jobs">Post a Project</a><a href="#categories">Browse Professionals</a><a href="#">Enterprise Solutions</a><a href="#">Pricing</a></div>
      <div class="footer-col"><h5>For Professionals</h5><a href="/register">Apply to Join</a><a href="/jobs">Find Work</a><a href="#">Resources</a><a href="#">Community</a></div>
      <div class="footer-col"><h5>Company</h5><a href="#">About Us</a><a href="#">Careers</a><a href="#">Blog</a><a href="#">Contact</a></div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 Oweru BuildConnect. All rights reserved.</span>
      <div><a href="#" style="color:#9ca3af; margin-left: 16px;">Terms</a><a href="#" style="color:#9ca3af; margin-left: 16px;">Privacy</a></div>
      <span>Built for Africa 🌍</span>
    </div>
  </div>
</footer>

<!-- Modal - PRESERVED FROM ORIGINAL -->
<div id="siteModal" class="modal">
  <div class="modal__box">
    <div class="modal__hd">
      <h3 id="modalTitle">Professionals</h3>
      <span class="modal__close" onclick="closeModal()">&times;</span>
    </div>
    <div id="step1" class="modal__body">
      <div id="typesGrid" class="types-grid" style="display: grid; grid-template-columns: repeat(2,1fr); gap: 12px;"></div>
    </div>
    <div id="step2" class="modal__body" style="display:none">
      <button class="back-btn" onclick="goBack()" style="margin-bottom: 16px;">← Back</button>
      <div id="selHdr"></div>
      <div id="prosList"></div>
    </div>
    <div class="modal__ft">
      <button class="btn-contact" onclick="closeModal()" style="width: auto; padding: 8px 24px;">Close</button>
    </div>
  </div>
</div>

<script>
// PRESERVED ORIGINAL JAVASCRIPT FUNCTIONALITY
const categoryData = {
  planning: { name: "Planning & Design", icon: "fas fa-drafting-compass", professionals: [] },
  construction: { name: "Construction Management", icon: "fas fa-hard-hat", professionals: [] },
  technical: { name: "MEP & Technical", icon: "fas fa-bolt", professionals: [] },
  finishing: { name: "Finishing & Interiors", icon: "fas fa-paint-roller", professionals: [] },
  legal: { name: "Legal & Compliance", icon: "fas fa-gavel", professionals: [] },
  management: { name: "Property Management", icon: "fas fa-building", professionals: [] }
};

const professionalsList = [
  { id: 1, name: "Emma Wright", profession: "Senior Architect", avatar: "https://randomuser.me/api/portraits/women/68.jpg", rating: 4.9, reviews: 142, location: "Lagos, NG", category: "planning" },
  { id: 2, name: "James Okafor", profession: "Structural Engineer", avatar: "https://randomuser.me/api/portraits/men/32.jpg", rating: 4.8, reviews: 97, location: "Nairobi, KE", category: "planning" },
  { id: 3, name: "Sophia Mensah", profession: "Project Manager", avatar: "https://randomuser.me/api/portraits/women/44.jpg", rating: 5.0, reviews: 211, location: "Accra, GH", category: "construction" },
  { id: 4, name: "David Mwangi", profession: "Electrical Engineer", avatar: "https://randomuser.me/api/portraits/men/46.jpg", rating: 4.7, reviews: 156, location: "Cape Town, ZA", category: "technical" },
  { id: 5, name: "Grace Ogunlesi", profession: "Quantity Surveyor", avatar: "https://randomuser.me/api/portraits/women/33.jpg", rating: 4.8, reviews: 89, location: "Lagos, NG", category: "legal" },
  { id: 6, name: "Michael Nkosi", profession: "Civil Engineer", avatar: "https://randomuser.me/api/portraits/men/41.jpg", rating: 4.9, reviews: 203, location: "Johannesburg, ZA", category: "planning" }
];

function renderCategories() {
  const cats = [
    { name: "Planning & Design", icon: "fas fa-drafting-compass", count: "342+", catKey: "planning" },
    { name: "Construction Management", icon: "fas fa-hard-hat", count: "528+", catKey: "construction" },
    { name: "MEP & Technical", icon: "fas fa-bolt", count: "415+", catKey: "technical" },
    { name: "Finishing & Interiors", icon: "fas fa-paint-roller", count: "289+", catKey: "finishing" },
    { name: "Legal & Compliance", icon: "fas fa-gavel", count: "156+", catKey: "legal" },
    { name: "Property Management", icon: "fas fa-building", count: "203+", catKey: "management" }
  ];
  const container = document.getElementById('categoryGrid');
  container.innerHTML = cats.map(c => `
    <div class="cat-card" data-category="${c.catKey}" onclick="openCategoryModal('${c.catKey}', '${c.name}', '${c.icon}')">
      <i class="${c.icon}"></i>
      <h4>${c.name}</h4>
      <p>${c.count} experts</p>
    </div>
  `).join('');
}

function renderPros() {
  const container = document.getElementById('prosGrid');
  container.innerHTML = professionalsList.map(p => `
    <div class="pro-card">
      <div class="pro-header">
        <img src="${p.avatar}" class="pro-avatar">
        <div class="pro-info">
          <h4>${p.name}</h4>
          <div class="pro-title">${p.profession}</div>
          <div class="pro-rating">${'★'.repeat(Math.floor(p.rating))}${p.rating%1 ? '½' : ''} ${p.rating}</div>
        </div>
      </div>
      <div class="pro-details"><span><i class="fas fa-map-marker-alt"></i> ${p.location}</span><span>⭐ ${p.reviews} reviews</span></div>
      <a href="#" class="btn-contact" onclick="openContactModal('${p.name}', '${p.profession}'); return false;">Contact Now</a>
    </div>
  `).join('');
}

function renderTestimonials() {
  const testimonials = [
    { text: "Oweru has transformed how we staff our construction projects across West Africa. The quality of professionals and the speed of matching is simply unmatched.", author: "Michael Adebayo", role: "COO, Shelter Afrique", img: "https://randomuser.me/api/portraits/men/41.jpg" },
    { text: "As a freelance architect, Oweru connected me with projects I never would have found. The escrow system gives me genuine peace of mind.", author: "Grace Mwangi", role: "Senior Architect, Nairobi", img: "https://randomuser.me/api/portraits/women/22.jpg" },
    { text: "The vetting process is rigorous. Every professional we've hired has been top-tier. It's our go-to platform for construction talent.", author: "Kwame Asante", role: "Project Director, Goldstar", img: "https://randomuser.me/api/portraits/men/75.jpg" }
  ];
  const container = document.getElementById('testimonialsGrid');
  container.innerHTML = testimonials.map(t => `
    <div class="testi-card">
      <div class="testi-text"><i class="fas fa-quote-left" style="color: #ff6a00; margin-right: 6px;"></i> "${t.text}"</div>
      <div class="testi-author" style="display: flex; align-items: center; gap: 12px; margin-top: 16px;">
        <img src="${t.img}" style="width: 40px; height: 40px; border-radius: 50%;">
        <div><strong>${t.author}</strong><br><span style="font-size: 12px; color: #7e8c9a;">${t.role}</span></div>
      </div>
    </div>
  `).join('');
}

// Modal functionality
const modal = document.getElementById('siteModal');
const step1 = document.getElementById('step1');
const step2 = document.getElementById('step2');
const typesGrid = document.getElementById('typesGrid');
const prosList = document.getElementById('prosList');
let currentCategory = null;

function closeModal() { modal.style.display = 'none'; step1.style.display = 'block'; step2.style.display = 'none'; }
function goBack() { step2.style.display = 'none'; step1.style.display = 'block'; }

function openCategoryModal(catKey, catName, catIcon) {
  currentCategory = catKey;
  document.getElementById('modalTitle').innerText = `${catName} Professionals`;
  const categoryPros = professionalsList.filter(p => p.category === catKey);
  const uniqueProfessions = [...new Map(categoryPros.map(p => [p.profession, p])).values()];
  typesGrid.innerHTML = uniqueProfessions.map(p => `
    <div class="cat-card" style="cursor:pointer; padding:16px;" onclick="selectProfession('${p.profession}')">
      <i class="${catIcon}"></i>
      <h4>${p.profession}</h4>
      <p>${categoryPros.filter(x => x.profession === p.profession).length} professional(s)</p>
    </div>
  `).join('');
  modal.style.display = 'flex';
}

function selectProfession(profession) {
  const pros = professionalsList.filter(p => p.category === currentCategory && p.profession === profession);
  prosList.innerHTML = pros.map(p => `
    <div class="pro-card" style="margin-bottom: 12px;">
      <div class="pro-header">
        <img src="${p.avatar}" class="pro-avatar" style="width: 48px; height: 48px;">
        <div><h4>${p.name}</h4><div class="pro-title">${p.profession}</div><div class="pro-rating">★ ${p.rating} (${p.reviews} reviews)</div></div>
      </div>
      <a href="#" class="btn-contact" onclick="openContactModal('${p.name}', '${p.profession}'); return false;">Contact</a>
    </div>
  `).join('');
  step1.style.display = 'none';
  step2.style.display = 'block';
}

function openContactModal(name, profession) {
  alert(`Contact request sent to ${name} (${profession}). Our team will connect you within 2 hours.`);
}

// Search functionality
document.getElementById('searchBtn')?.addEventListener('click', () => {
  const query = document.querySelector('#keywordInput')?.value;
  if(query) alert(`Searching for "${query}" — connecting you with top construction professionals.`);
  else alert('Please enter a profession or skill');
});

// Sticky header
window.addEventListener('scroll', () => {
  const header = document.querySelector('.main-header');
  if (header) header.classList.toggle('scrolled', window.scrollY > 20);
});

// Initialize all
renderCategories();
renderPros();
renderTestimonials();
</script>
</body>
</html>