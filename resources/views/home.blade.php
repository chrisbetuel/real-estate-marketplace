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
   ENHANCED DECORATIONS ADDED + DROPDOWN MENUS
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

/* ===== BACKGROUND IMAGE ===== */
body::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070&auto=format');
  background-size: cover;
  background-position: center 30%;
  background-repeat: no-repeat;
  filter: brightness(0.35) contrast(1.05);
  z-index: -2;
}

body::after {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: -1;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

/* Top Bar - Alibaba Trust Bar */
.top-bar {
  background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
  border-bottom: 1px solid #e4e7ed;
  font-size: 12px;
  padding: 8px 0;
  color: #6c757d;
  position: relative;
  overflow: hidden;
}
.top-bar::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(200,145,40,0.05), transparent);
  animation: shimmer 8s infinite;
}
@keyframes shimmer {
  0% { left: -100%; }
  100% { left: 100%; }
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
  transition: all 0.3s ease;
  position: relative;
}
.top-links a::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 2px;
  background: #C89128;
  transition: width 0.3s ease;
}
.top-links a:hover::after {
  width: 100%;
}
.top-links a:hover { color: #C89128; transform: translateY(-1px); }
.top-links a.cta-link { color: #C89128; font-weight: 600; }

/* Header - Sticky with glass effect */
.main-header {
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(10px);
  position: sticky;
  top: 0;
  z-index: 100;
  border-bottom: 1px solid #eef2f6;
  box-shadow: 0 4px 20px rgba(0,0,0,0.03);
  transition: all 0.3s ease;
}
.main-header.scrolled {
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}
.header-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 76px;
}

/* Logo with hover animation */
.logo {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
  position: relative;
}
.logo-icon {
  width: 42px;
  height: 42px;
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  animation: float 3s ease-in-out infinite;
}
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.logo:hover .logo-icon {
  transform: scale(1.05) rotate(5deg);
}
.logo-text h2 {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: -0.5px;
  background: linear-gradient(135deg, #1e293b 0%, #2d3a4f 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.logo-text span { color: #C89128; -webkit-text-fill-color: #C89128; }
.logo-text p {
  font-size: 9px;
  color: #7e8c9a;
  letter-spacing: 1px;
  margin-top: 2px;
}

/* Search Box with pulse effect on focus */
.search-wrapper {
  flex: 1;
  max-width: 520px;
  margin: 0 32px;
}
.search-box {
  display: flex;
  border: 2px solid #C89128;
  border-radius: 12px;
  overflow: hidden;
  background: white;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(200,145,40,0.1);
}
.search-box:focus-within {
  box-shadow: 0 4px 20px rgba(200,145,40,0.2);
  transform: translateY(-1px);
}
.search-box input {
  flex: 1;
  padding: 12px 18px;
  border: none;
  font-size: 14px;
  outline: none;
}
.search-box button {
  background: linear-gradient(135deg, #C89128 0%, #E0A83C 100%);
  border: none;
  padding: 0 28px;
  color: white;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}
.search-box button::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255,255,255,0.2);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}
.search-box button:hover::before {
  width: 300px;
  height: 300px;
}
.search-box button:hover { background: linear-gradient(135deg, #E0A83C 0%, #C89128 100%); transform: scale(1.02); }

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
  transition: all 0.3s ease;
  position: relative;
}
.action-item i {
  font-size: 20px;
  display: block;
  margin-bottom: 4px;
  transition: transform 0.3s ease;
}
.action-item:hover { color: #C89128; }
.action-item:hover i {
  transform: translateY(-2px);
}

/* ===== DROPDOWN MENU STYLES - LIGHT THEME ===== */
.nav-cats {
  background: rgba(255, 255, 255, 0.95);
  border-bottom: 1px solid #eef2f6;
  position: relative;
  z-index: 99;
}
.cat-links {
  display: flex;
  gap: 28px;
  padding: 12px 0;
  font-size: 14px;
  font-weight: 500;
  flex-wrap: wrap;
}

/* Dropdown container */
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-toggle {
  text-decoration: none;
  color: #374151;
  transition: all 0.3s ease;
  position: relative;
  cursor: pointer;
  padding: 8px 0;
  display: inline-block;
}

.dropdown-toggle::after {
  content: '';
  position: absolute;
  bottom: -12px;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, #C89128, #E0A83C);
  transition: width 0.3s ease;
}

.dropdown-toggle:hover::after,
.dropdown-toggle.active::after {
  width: 100%;
}

.dropdown-toggle:hover, 
.dropdown-toggle.active { 
  color: #C89128; 
}

/* Dropdown arrow icon */
.dropdown-toggle i.fa-chevron-down {
  font-size: 10px;
  margin-left: 4px;
  transition: transform 0.3s ease;
}

.dropdown:hover .dropdown-toggle i.fa-chevron-down {
  transform: rotate(180deg);
}

/* Dropdown menu */
.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  background: white;
  min-width: 200px;
  border-radius: 12px;
  box-shadow: 0 12px 30px rgba(0,0,0,0.1);
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.3s ease;
  z-index: 1000;
  border: 1px solid #eef2f6;
  overflow: hidden;
  margin-top: 8px;
}

.dropdown:hover .dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.dropdown-menu a {
  display: block;
  padding: 12px 20px;
  text-decoration: none;
  color: #374151;
  font-size: 13px;
  transition: all 0.2s ease;
  border-bottom: 1px solid #f0f2f5;
}

.dropdown-menu a:last-child {
  border-bottom: none;
}

.dropdown-menu a:hover {
  background: linear-gradient(90deg, #fefaf5, #fff);
  color: #C89128;
  padding-left: 26px;
}

/* Right-aligned dropdown for some items */
.dropdown-menu-right {
  left: auto;
  right: 0;
}

/* Mobile dropdown handling */
@media (max-width: 768px) {
  .cat-links {
    gap: 16px;
  }
  .dropdown-menu {
    position: static;
    opacity: 1;
    visibility: visible;
    transform: none;
    box-shadow: none;
    border: none;
    background: transparent;
    margin-top: 0;
    display: none;
  }
  .dropdown:hover .dropdown-menu {
    display: block;
  }
  .dropdown-toggle::after {
    display: none;
  }
}

/* Hero Section - Alibaba Style */
.hero-section {
  background: linear-gradient(135deg, #fefaf5 0%, #ffffff 50%, #f8fafc 100%);
  padding: 40px 0;
  border-bottom: 1px solid #f0f2f5;
  position: relative;
  overflow: hidden;
}
.hero-section::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 80%;
  height: 150%;
  background: radial-gradient(circle, rgba(200,145,40,0.03) 0%, transparent 70%);
  pointer-events: none;
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
  background: linear-gradient(135deg, #1e293b 0%, #C89128 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.hero-left h1 span { color: #C89128; -webkit-text-fill-color: #C89128; }
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
.stat { text-align: left; position: relative; }
.stat .number { 
  font-size: 28px; 
  font-weight: 800; 
  background: linear-gradient(135deg, #1e293b 0%, #C89128 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
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
  border-radius: 12px;
  padding: 12px 16px;
  transition: all 0.3s ease;
}
.hero-search-input:focus-within { 
  border-color: #C89128;
  box-shadow: 0 0 0 3px rgba(200,145,40,0.1);
}
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
  transition: all 0.3s ease;
}
.hero-tags a:hover { 
  background: linear-gradient(135deg, #C89128, #E0A83C);
  color: white;
  transform: translateY(-2px);
}

.hero-right {
  background: linear-gradient(135deg, #1e2a3a 0%, #0f172a 100%);
  border-radius: 20px;
  padding: 32px;
  color: white;
  position: relative;
  overflow: hidden;
  transition: transform 0.3s ease;
}
.hero-right:hover {
  transform: translateY(-5px);
}
.hero-right::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -20%;
  width: 140%;
  height: 200%;
  background: radial-gradient(circle, rgba(200,145,40,0.1) 0%, transparent 70%);
  pointer-events: none;
}
.hero-stats {
  display: flex;
  justify-content: space-between;
  margin-bottom: 24px;
}
.hero-stats .stat-item { text-align: center; }
.hero-stats .stat-val { 
  font-size: 32px; 
  font-weight: 800; 
  background: linear-gradient(135deg, #C89128 0%, #E0A83C 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
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
  border: 2px solid #C89128;
  transition: transform 0.3s ease;
}
.testi-author img:hover {
  transform: scale(1.05);
}

/* Trust Bar */
.trust-bar {
  background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
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
  transition: all 0.3s ease;
  cursor: pointer;
}
.trust-list li:hover {
  transform: translateX(5px);
  color: #C89128;
}
.trust-list svg { width: 16px; stroke: #C89128; transition: transform 0.3s ease; }
.trust-list li:hover svg { transform: scale(1.2); }

/* Section Styles with decorative lines */
.section { 
  padding: 56px 0; 
  border-bottom: 1px solid #edf2f7;
  position: relative;
}
.section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 1px;
  background: linear-gradient(90deg, transparent, #C89128, transparent);
}
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
}
.section-header h2 {
  font-size: 24px;
  font-weight: 700;
  position: relative;
  display: inline-block;
}
.section-header h2::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #C89128, #E0A83C);
  border-radius: 3px;
}
.section-header h2 em { color: #C89128; font-style: normal; }
.section-header a {
  color: #C89128;
  font-size: 13px;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}
.section-header a:hover {
  transform: translateX(5px);
  color: #E0A83C;
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
  border-radius: 16px;
  padding: 24px 12px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  color: inherit;
  position: relative;
  overflow: hidden;
}
.cat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(200,145,40,0.05), transparent);
  transition: left 0.6s;
}
.cat-card:hover::before {
  left: 100%;
}
.cat-card:hover {
  border-color: #C89128;
  transform: translateY(-8px);
  box-shadow: 0 12px 30px rgba(200,145,40,0.15);
}
.cat-card i { 
  font-size: 36px; 
  background: linear-gradient(135deg, #C89128 0%, #E0A83C 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 12px; 
  display: block;
  transition: transform 0.3s ease;
}
.cat-card:hover i {
  transform: scale(1.1);
}
.cat-card h4 { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
.cat-card p { font-size: 11px; color: #7e8c9a; }

/* Split Section with decorative borders */
.split-section {
  display: grid;
  grid-template-columns: 1fr 1fr;
  position: relative;
}
.split-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  width: 1px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #C89128, transparent);
}
.split-panel {
  padding: 64px 48px;
  transition: transform 0.3s ease;
}
.split-panel:hover {
  transform: scale(1.02);
}
.light-panel { 
  background: linear-gradient(135deg, #fefcf9 0%, #ffffff 100%);
}
.dark-panel { 
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: white; 
}
.split-panel h3 {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 16px;
}
.split-panel h3 em { color: #C89128; font-style: normal; }
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
  transition: transform 0.3s ease;
}
.checklist li:hover {
  transform: translateX(5px);
}
.check-icon svg { width: 16px; stroke: #C89128; stroke-width: 2.5; }

/* Pros Grid */
.pros-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.pro-card {
  border: 1px solid #eef2f6;
  border-radius: 16px;
  padding: 20px;
  background: white;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}
.pro-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: linear-gradient(90deg, #C89128, #E0A83C);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}
.pro-card:hover::before {
  transform: scaleX(1);
}
.pro-card:hover {
  border-color: #C89128;
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(200,145,40,0.1);
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
  border: 2px solid #C89128;
  transition: transform 0.3s ease;
}
.pro-card:hover .pro-avatar {
  transform: scale(1.05);
}
.pro-info h4 { font-size: 16px; font-weight: 700; }
.pro-title { font-size: 12px; color: #C89128; font-weight: 500; margin: 2px 0; }
.pro-rating { color: #C89128; font-size: 12px; }
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
  background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
  border: 1px solid #e2e8f0;
  padding: 10px;
  border-radius: 10px;
  font-size: 12px;
  font-weight: 600;
  text-align: center;
  display: block;
  text-decoration: none;
  color: #1f2937;
  transition: all 0.3s ease;
  cursor: pointer;
}
.btn-contact:hover { 
  background: linear-gradient(135deg, #C89128, #E0A83C);
  color: white; 
  border-color: #C89128;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(200,145,40,0.3);
}

/* Steps with animated numbers */
.steps-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.step {
  text-align: center;
  padding: 24px;
  transition: all 0.3s ease;
}
.step:hover {
  transform: translateY(-5px);
}
.step-num {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #fff3e8 0%, #fff9f0 100%);
  color: #C89128;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 20px;
  margin-bottom: 16px;
  transition: all 0.3s ease;
}
.step:hover .step-num {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(200,145,40,0.2);
}
.step h4 { font-size: 18px; margin-bottom: 8px; }
.step p { font-size: 13px; color: #5a6874; }

/* Testimonials with glowing border */
.testi-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.testi-card {
  background: linear-gradient(135deg, #fefcf9 0%, #ffffff 100%);
  padding: 24px;
  border-radius: 20px;
  border: 1px solid #f0f2f5;
  transition: all 0.3s ease;
}
.testi-card:hover {
  border-color: #C89128;
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(200,145,40,0.1);
}
.testi-text {
  font-size: 14px;
  color: #334155;
  margin-bottom: 16px;
  line-height: 1.6;
}

/* CTA Banner with animated gradient */
.cta-banner {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
  padding: 64px 0;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.cta-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(200,145,40,0.05) 0%, transparent 70%);
  animation: rotate 20s linear infinite;
}
@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.cta-banner h2 {
  color: white;
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 16px;
}
.cta-banner h2 em { color: #C89128; font-style: normal; }
.cta-banner p { color: #94a3b8; margin-bottom: 32px; }

/* Footer with gradient border */
.footer {
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: #9ca3af;
  padding: 56px 0 32px;
  position: relative;
}
.footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #C89128, transparent);
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
  position: relative;
  display: inline-block;
}
.footer-col h5::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 30px;
  height: 2px;
  background: #C89128;
}
.footer-col a {
  display: block;
  color: #9ca3af;
  text-decoration: none;
  font-size: 13px;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}
.footer-col a:hover { 
  color: #C89128;
  transform: translateX(5px);
}
.footer-bottom {
  border-top: 1px solid #334155;
  padding-top: 24px;
  text-align: center;
  font-size: 12px;
  display: flex;
  justify-content: space-between;
}

/* Modal with animation */
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.8);
  backdrop-filter: blur(8px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
.modal__box {
  background: white;
  max-width: 500px;
  width: 90%;
  border-radius: 20px;
  overflow: hidden;
  animation: slideUp 0.3s ease;
}
@keyframes slideUp {
  from { transform: translateY(50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
.modal__hd {
  padding: 20px 24px;
  border-bottom: 2px solid #eef2f6;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(135deg, #fefcf9, #ffffff);
}
.modal__close {
  cursor: pointer;
  font-size: 28px;
  transition: transform 0.3s ease;
}
.modal__close:hover {
  transform: rotate(90deg);
  color: #C89128;
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
  .split-section::before { display: none; }
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
  .hero-left h1 { font-size: 28px; }
  .cat-links { gap: 12px; }
  .dropdown-menu { position: static; opacity: 1; visibility: visible; transform: none; box-shadow: none; border: none; background: transparent; margin-top: 0; display: none; }
  .dropdown:hover .dropdown-menu { display: block; }
}

/* Scrollbar styling */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}
::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, #C89128, #E0A83C);
  border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(135deg, #E0A83C, #C89128);
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
        <div class="logo-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C89128" stroke-width="2"><path d="M4 20 L8 8 L12 14 L16 9 L20 20"/></svg></div>
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

<!-- Navigation Tabs WITH DROPDOWN MENUS - All items have hover dropdowns -->
<div class="nav-cats">
  <div class="container">
    <div class="cat-links">
      <!-- Find Work Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">Find Work <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="/jobs">Browse Projects</a>
          <a href="/jobs/recommended">Recommended Jobs</a>
          <a href="/saved-jobs">Saved Jobs</a>
          
        </div>
      </div>
      <!-- Hire Talent Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">Hire Talent <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="#categories">Search Professionals</a>
          <a href="/post-project">Post a Project</a>
          
        </div>
      </div>
      <!-- manage Single Shop Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">{{ route('pos.single-shop') ? 'manage Single Shop' : 'manage Single Shop' }} <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="{{ route('pos.single-shop') }}">Dashboard</a>
          <a href="{{ route('pos.single-shop') }}/products">Products</a>
          <a href="{{ route('pos.single-shop') }}/orders">Orders</a>
          <a href="{{ route('pos.single-shop') }}/settings">Settings</a>
          <a href="{{ route('pos.single-shop') }}/analytics">Analytics</a>
        </div>
      </div>
      <!-- manage Multi Shop Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">{{ route('pos.multi-shop') ? 'manage Multi Shop' : 'manage Multi Shop' }} <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="{{ route('pos.multi-shop') }}">All Shops</a>
          <a href="{{ route('pos.multi-shop') }}/add">Add New Shop</a>
          <a href="{{ route('pos.multi-shop') }}/inventory">Inventory Management</a>
          <a href="{{ route('pos.multi-shop') }}/analytics">Multi-Shop Analytics</a>
          <a href="{{ route('pos.multi-shop') }}/staff">Staff Management</a>
        </div>
      </div>
      <!-- For Clients Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">For Clients <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="/post-project">Post a Project</a>
          <a href="#categories">Browse Professionals</a>
          
          <a href="/success-stories">Success Stories</a>
          
        </div>
      </div>
      <!-- For Professionals Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">For Professionals <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="/register">Apply to Join</a>
          <a href="/jobs">Find Work</a>
          
        </div>
      </div>
      <!-- Company Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">Company <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="/about">About Us</a>
          
          <a href="/contact">Contact Us</a>
        </div>
      </div>
      <!-- Why Oweru Dropdown -->
      <div class="dropdown">
        <span class="dropdown-toggle">Why Oweru <i class="fas fa-chevron-down"></i></span>
        <div class="dropdown-menu">
          <a href="/about">About Us</a>
          <a href="/how-it-works">How It Works</a>
          <a href="/success-stories">Success Stories</a>
          <a href="/contact">Contact</a>
        </div>
      </div>
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
          <button type="submit" class="search-box" style="border: none; background: #C89128; padding: 0 28px; border-radius: 8px; color: white; font-weight: 600;">Find Nearby →</button>
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
    <a href="/jobs" class="btn-contact" style="width: auto; display: inline-block; padding: 12px 28px; background: #C89128; color: white;">Browse Open Roles →</a>
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
      <a href="/register" class="btn-contact" style="background: #C89128; color: white; width: auto; padding: 12px 32px;">Get Started Free →</a>
      <a href="#" class="btn-contact" style="background: transparent; border: 1px solid #C89128; color: white; width: auto; padding: 12px 32px;">Talk to Sales</a>
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
          <div class="logo-icon" style="background: #C89128;"><svg width="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M4 20 L8 8 L12 14 L16 9 L20 20"/></svg></div>
          <div class="logo-text"><h2 style="color:white;">OWERU<span>Build</span></h2></div>
        </a>
        <p style="font-size: 13px;">Connecting Africa's best construction professionals with leading projects across the continent.</p>
      </div>
      <div class="footer-col"><h5>For Clients</h5><a href="/post-project">Post a Project</a><a href="#categories">Browse Professionals</a><a href="/enterprise">Enterprise Solutions</a><a href="/pricing">Pricing</a><a href="/success-stories">Success Stories</a></div>
      <div class="footer-col"><h5>For Professionals</h5><a href="/register">Apply to Join</a><a href="/jobs">Find Work</a><a href="/resources">Resources</a><a href="/community">Community</a><a href="/toolkit">Success Toolkit</a></div>
      <div class="footer-col"><h5>Company</h5><a href="/about">About Us</a><a href="/careers">Careers</a><a href="/blog">Blog</a><a href="/press">Press</a><a href="/contact">Contact</a></div>
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
// PRESERVED ORIGINAL JAVASCRIPT FUNCTIONALITY - COMPLETELY UNCHANGED
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