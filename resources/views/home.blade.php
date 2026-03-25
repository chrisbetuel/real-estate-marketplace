<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oweru Real Estate - Professional Marketplace</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* Brand Colors */
        :root {
            --primary-dark: #0F172A;
            --soft-white: #F8F8F9;
            --soft-white-rgb: 248, 248, 249;
            --gold-accent: #C9A53B;
            --light-grey: #E5E5E5;
            --medium-grey: #D9D9D9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Raleway', sans-serif;
            background-color: var(--light-grey);
            color: var(--primary-dark);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        
        .gold-text {
            color: var(--gold-accent) !important;
        }
        
        .white-text {
            color: var(--soft-white) !important;
        }
        
        /* Navbar Styling */
        .navbar {
            background: var(--primary-dark) !important;
            padding: 15px 0;
            transition: all 0.3s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-brand {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--soft-white) !important;
            letter-spacing: -0.5px;
        }
        
        .oweru-logo {
            height: 50px;
            width: auto;
            margin-right: 10px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }
        
        .nav-link {
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
            color: var(--soft-white) !important;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s;
            opacity: 0.9;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--gold-accent);
            transition: width 0.3s;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .nav-link:hover {
            opacity: 1;
        }
        
        .btn-nav-register {
            background: var(--gold-accent);
            color: var(--primary-dark) !important;
            border-radius: 50px;
            padding: 10px 25px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            opacity: 1 !important;
            font-weight: 600;
        }
        
        .btn-nav-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201, 165, 59, 0.4);
            background: var(--gold-accent);
        }
        
        /* Hero Section with Moving Background */
        .hero-section {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: var(--primary-dark);
        }
        
        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        
        .hero-background .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            animation: slideShow 24s infinite;
        }
        
        .hero-background .slide:nth-child(1) {
            background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            animation-delay: 0s;
        }
        
        .hero-background .slide:nth-child(2) {
            background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            animation-delay: 6s;
        }
        
        .hero-background .slide:nth-child(3) {
            background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            animation-delay: 12s;
        }
        
        .hero-background .slide:nth-child(4) {
            background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            animation-delay: 18s;
        }
        
        @keyframes slideShow {
            0% { opacity: 0; }
            10% { opacity: 1; }
            25% { opacity: 1; }
            35% { opacity: 0; }
            100% { opacity: 0; }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            color: var(--soft-white);
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .hero-logo {
            width: 120px;
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .hero-title {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
            color: var(--soft-white);
        }
        
        .hero-title span {
            color: var(--gold-accent);
        }
        
        .hero-subtitle {
            font-family: 'Raleway', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.9;
            text-shadow: 1px 1px 10px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease 0.2s both;
            color: var(--soft-white);
        }
        
        .hero-buttons {
            animation: fadeInUp 1s ease 0.4s both;
        }
        
        .btn-hero {
            padding: 15px 40px;
            font-family: 'Raleway', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 0 10px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-hero-primary {
            background: var(--gold-accent);
            color: var(--primary-dark);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .btn-hero-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(201, 165, 59, 0.4);
            background: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        .btn-hero-outline {
            background: transparent;
            color: var(--soft-white);
            border: 2px solid var(--gold-accent);
            backdrop-filter: blur(5px);
        }
        
        .btn-hero-outline:hover {
            background: var(--gold-accent);
            color: var(--primary-dark);
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(201, 165, 59, 0.3);
        }
        
        /* Search Section */
        .search-section {
            position: relative;
            z-index: 3;
            margin-top: -80px;
            margin-bottom: 60px;
        }
        
        .search-card {
            background: var(--soft-white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
            border: none;
        }
        
        .search-title {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .search-title i {
            color: var(--gold-accent);
        }
        
        .search-input {
            border-radius: 15px;
            padding: 15px 20px;
            border: 2px solid var(--light-grey);
            font-family: 'Raleway', sans-serif;
            transition: all 0.3s;
            background-color: var(--soft-white);
        }
        
        .search-input:focus {
            border-color: var(--gold-accent);
            box-shadow: 0 0 0 3px rgba(201, 165, 59, 0.2);
        }
        
        .btn-search {
            background: var(--primary-dark);
            color: var(--soft-white);
            border-radius: 15px;
            padding: 15px 30px;
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            border: none;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
            background: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        /* Categories Section - Grey Background */
        .categories-section {
            background-color: var(--light-grey);
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .section-title h2 span {
            color: var(--gold-accent);
        }
        
        .section-title p {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.7;
            font-size: 1.1rem;
        }
        
        .category-card {
            background: var(--soft-white);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            transition: all 0.3s;
            border: none;
            height: 100%;
            cursor: pointer;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            line-height: 80px;
            background: var(--primary-dark);
            color: var(--soft-white);
            border-radius: 50%;
            margin: 0 auto 20px;
            font-size: 2rem;
            transition: all 0.3s;
        }
        
        .category-card:hover .category-icon {
            background: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        .category-card h5 {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }
        
        .category-card p {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        /* Featured Jobs Section - Grey Background */
        .featured-jobs-section {
            background-color: var(--medium-grey);
            padding: 60px 0;
        }
        
        .job-card {
            background: var(--soft-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            transition: all 0.3s;
            border: none;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .job-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gold-accent);
        }
        
        .job-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
        }
        
        .job-category {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(201, 165, 59, 0.1);
            color: var(--gold-accent);
            border-radius: 50px;
            font-family: 'Raleway', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .job-title {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }
        
        .job-location {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.7;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .job-location i {
            color: var(--gold-accent);
        }
        
        .job-description {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.6;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .job-budget {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 20px;
        }
        
        .job-budget i {
            color: var(--gold-accent);
        }
        
        .btn-job {
            background: transparent;
            border: 2px solid var(--primary-dark);
            color: var(--primary-dark);
            border-radius: 50px;
            padding: 8px 25px;
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-job:hover {
            background: var(--gold-accent);
            border-color: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        /* Featured Products Section - Light Grey Background */
        .featured-products-section {
            background-color: var(--light-grey);
            padding: 60px 0;
        }
        
        .product-card {
            background: var(--soft-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            transition: all 0.3s;
            border: none;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
        }
        
        .product-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--gold-accent);
            color: var(--primary-dark);
            padding: 5px 15px;
            border-radius: 50px;
            font-family: 'Raleway', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .product-body {
            padding: 20px;
        }
        
        .product-title {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }
        
        .product-price {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .btn-product {
            background: var(--primary-dark);
            color: var(--soft-white);
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.3);
            background: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        /* How It Works Section - Grey Background */
        .how-it-works-section {
            background-color: var(--medium-grey);
            padding: 60px 0;
        }
        
        .step-card {
            text-align: center;
            padding: 30px;
            position: relative;
            background: var(--soft-white);
            border-radius: 20px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }
        
        .step-number {
            width: 60px;
            height: 60px;
            line-height: 60px;
            background: var(--primary-dark);
            color: var(--soft-white);
            border-radius: 50%;
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 20px;
        }
        
        .step-icon {
            font-size: 2.5rem;
            color: var(--gold-accent);
            margin-bottom: 20px;
        }
        
        .step-card h4 {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .step-card p {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.7;
        }
        
        /* Testimonials Section - Light Grey Background */
        .testimonials-section {
            background-color: var(--light-grey);
            padding: 60px 0;
        }
        
        .testimonial-card {
            background: var(--soft-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            margin: 20px 0;
            height: 100%;
        }
        
        .testimonial-rating {
            color: var(--gold-accent);
            margin-bottom: 15px;
        }
        
        .testimonial-text {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.8;
            font-style: italic;
            margin-bottom: 20px;
            font-size: 1rem;
            line-height: 1.8;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            border: 2px solid var(--gold-accent);
        }
        
        .author-name {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }
        
        .author-title {
            font-family: 'Raleway', sans-serif;
            color: var(--primary-dark);
            opacity: 0.6;
            font-size: 0.85rem;
        }
        
        /* CTA Section - Keep as is (Dark Blue) */
        .cta-section {
            background: var(--primary-dark);
            border-radius: 30px;
            padding: 80px 40px;
            text-align: center;
            color: var(--soft-white);
            margin: 60px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section:before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(201, 165, 59, 0.1);
            border-radius: 50%;
        }
        
        .cta-section:after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(201, 165, 59, 0.1);
            border-radius: 50%;
        }
        
        .cta-title {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            color: var(--soft-white);
        }
        
        .cta-text {
            font-family: 'Raleway', sans-serif;
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            color: var(--soft-white);
        }
        
        .btn-cta {
            background: var(--gold-accent);
            color: var(--primary-dark);
            border-radius: 50px;
            padding: 15px 40px;
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
        }
        
        .btn-cta:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(201, 165, 59, 0.4);
            background: var(--gold-accent);
            color: var(--primary-dark);
        }
        
        /* Footer - Dark Blue with White and Gold text */
        .footer {
            background: var(--primary-dark);
            color: var(--soft-white);
            padding: 60px 0 30px;
            margin-top: 80px;
        }
        
        .footer-logo {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--soft-white);
            margin-bottom: 20px;
        }
        
        .footer-logo span {
            color: var(--gold-accent);
        }
        
        .footer-text {
            font-family: 'Raleway', sans-serif;
            color: var(--soft-white);
            opacity: 0.8;
            line-height: 1.8;
        }
        
        .footer-links h5 {
            font-family: 'Nunito', 'Futura PT', sans-serif;
            color: var(--gold-accent);
            font-weight: 700;
            margin-bottom: 25px;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            font-family: 'Raleway', sans-serif;
            color: var(--soft-white);
            opacity: 0.8;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--gold-accent);
            opacity: 1;
            padding-left: 5px;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: rgba(248, 248, 249, 0.1);
            color: var(--soft-white);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: var(--gold-accent);
            color: var(--primary-dark);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(201, 165, 59, 0.3);
            padding-top: 30px;
            margin-top: 40px;
            text-align: center;
            font-family: 'Raleway', sans-serif;
            color: var(--soft-white);
            opacity: 0.8;
        }
        
        .footer-bottom span {
            color: var(--gold-accent);
            font-weight: 600;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="logo-white.png" alt="BuildConnect Logo" class="oweru-logo">                <span class="white-text brand-font" style="font-weight: 800; font-size: 1.8rem; letter-spacing: -0.5px;">BUILDCONNECT</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="background-color: var(--gold-accent);">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jobs.index') }}">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stores.index') }}">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-nav-register" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Moving Background -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="slide"></div>
            <div class="slide"></div>
            <div class="slide"></div>
            <div class="slide"></div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <img src="logo-white.png" alt="BuildConnect Logo" class="hero-logo">               <h1 class="hero-title animate__animated animate__fadeInUp">Welcome to <span class="gold-text">BuildConnect</span></h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">Connect with professionals for your real estate projects</p>
                
                <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-2s">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                            <i class="fas fa-user-plus me-2"></i>Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @else
                        <a href="{{ route('jobs.create') }}" class="btn btn-hero btn-hero-primary">
                            <i class="fas fa-plus-circle me-2"></i>Post a Job
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-search me-2"></i>Browse Jobs
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="search-card">
                        <h3 class="search-title">
                            <i class="fas fa-search me-2"></i>Find What You Need
                        </h3>
                        <form action="{{ route('search.jobs') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="keyword" class="form-control search-input" placeholder="What service?">
                                </div>
                                <div class="col-md-3">
                                    <select name="category" class="form-select search-input">
                                        <option value="">All Categories</option>
                                        <option value="Engineer">Engineer</option>
                                        <option value="Architect">Architect</option>
                                        <option value="Designer">Designer</option>
                                        <option value="Electrician">Electrician</option>
                                        <option value="Plumber">Plumber</option>
                                        <option value="Carpenter">Carpenter</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="location" class="form-control search-input" placeholder="Location">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section - Grey Background -->
    <section class="categories-section">
        <div class="container">
            <div class="section-title">
                <h2>Popular <span>Categories</span></h2>
                <p>Find professionals in your area</p>
            </div>
            
            <div class="row">
                @php
                $categories = [
                    ['icon' => 'fa-hard-hat', 'name' => 'Engineers', 'count' => 150],
                    ['icon' => 'fa-pencil-ruler', 'name' => 'Designers', 'count' => 200],
                    ['icon' => 'fa-tools', 'name' => 'Construction', 'count' => 300],
                    ['icon' => 'fa-paint-roller', 'name' => 'Painters', 'count' => 120],
                    ['icon' => 'fa-bolt', 'name' => 'Electricians', 'count' => 180],
                    ['icon' => 'fa-wrench', 'name' => 'Plumbers', 'count' => 160],
                    ['icon' => 'fa-couch', 'name' => 'Interior Design', 'count' => 90],
                    ['icon' => 'fa-tree', 'name' => 'Landscapers', 'count' => 75],
                ];
                @endphp
                
                @foreach($categories as $category)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas {{ $category['icon'] }}"></i>
                        </div>
                        <h5>{{ $category['name'] }}</h5>
                        <p>{{ $category['count'] }} professionals</p>
                        <a href="{{ route('search.professionals', ['category' => $category['name']]) }}" 
                           class="btn btn-link text-decoration-none" style="color: var(--gold-accent); font-weight: 600;">Browse <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section - Grey Background -->
    <section class="featured-jobs-section">
        <div class="container">
            <div class="section-title">
                <h2>Featured <span>Jobs</span></h2>
                <p>Latest opportunities from top clients</p>
            </div>
            
            <div class="row">
                @forelse($featuredJobs as $job)
                <div class="col-md-4 mb-4">
                    <div class="job-card">
                        <span class="job-category">{{ $job->service_category }}</span>
                        <h3 class="job-title">{{ $job->title }}</h3>
                        <p class="job-location">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $job->location }}
                        </p>
                        <p class="job-description">{{ Str::limit($job->description, 100) }}</p>
                        <div class="job-budget">
                            <i class="fas fa-tag me-2"></i>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                            </small>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-job">View Details</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No featured jobs available</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('jobs.index') }}" class="btn btn-lg" style="background: var(--gold-accent); color: var(--primary-dark); padding: 12px 40px; border-radius: 50px; font-family: 'Raleway', sans-serif; font-weight: 600;">
                    Browse All Jobs <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section - Light Grey Background -->
    <section class="featured-products-section">
        <div class="container">
            <div class="section-title">
                <h2>Featured <span>Products</span></h2>
                <p>Quality products from trusted stores</p>
            </div>
            
            <div class="row">
                @forelse($featuredProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('{{ $product->images[0] ?? 'https://via.placeholder.com/300x200/0F172A/F8F8F9' }}')">
                            <span class="product-badge">{{ ucfirst($product->type) }}</span>
                        </div>
                        <div class="product-body">
                            <h4 class="product-title">{{ $product->name }}</h4>
                            @if($product->price_sale)
                                <div class="product-price">${{ number_format($product->price_sale) }}</div>
                            @endif
                            @if($product->price_rent)
                                <div class="product-price">${{ number_format($product->price_rent) }}/{{ $product->rent_period }}</div>
                            @endif
                            <a href="{{ route('products.show', $product) }}" class="btn btn-product">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No featured products available</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-lg" style="background: var(--gold-accent); color: var(--primary-dark); padding: 12px 40px; border-radius: 50px; font-family: 'Raleway', sans-serif; font-weight: 600;">
                    Browse All Products <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section - Grey Background -->
    <section class="how-it-works-section">
        <div class="container">
            <div class="section-title">
                <h2>How <span>Oweru</span> Works</h2>
                <p>Simple steps to get started</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h4>Create Account</h4>
                        <p>Sign up as a client or professional in minutes</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4>Find or Post</h4>
                        <p>Browse jobs or post your requirements</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Connect & Agree</h4>
                        <p>Communicate and agree on terms</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
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

    <!-- Testimonials Section - Light Grey Background -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>What Our <span>Users Say</span></h2>
                <p>Trusted by professionals and clients</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Found an excellent architect for my home renovation project. The platform made it easy to compare bids."</p>
                        <div class="testimonial-author">
                            <img src="https://via.placeholder.com/50x50/0F172A/F8F8F9?text=JD" alt="John Doe" class="author-image">
                            <div>
                                <div class="author-name">John Doe</div>
                                <div class="author-title">Homeowner</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"As a freelance architect, this platform has helped me find consistent work. The payment protection system is great."</p>
                        <div class="testimonial-author">
                            <img src="https://via.placeholder.com/50x50/0F172A/F8F8F9?text=JS" alt="Jane Smith" class="author-image">
                            <div>
                                <div class="author-name">Jane Smith</div>
                                <div class="author-title">Architect</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Great platform for finding quality construction materials. The store locator feature helped me find a nearby supplier."</p>
                        <div class="testimonial-author">
                            <img src="https://via.placeholder.com/50x50/0F172A/F8F8F9?text=MJ" alt="Mike Johnson" class="author-image">
                            <div>
                                <div class="author-name">Mike Johnson</div>
                                <div class="author-title">Contractor</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section - Keep as is (Dark Blue) -->
    <section class="container">
        <div class="cta-section">
            <h2 class="cta-title">Ready to start your next project?</h2>
            <p class="cta-text">Join thousands of professionals and clients already using Oweru</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-cta btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Sign Up Now
                </a>
            @else
                <a href="{{ route('jobs.create') }}" class="btn btn-cta btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>Post a Job
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer - Dark Blue with White and Gold text -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-logo">
                        <img src="logo-white.png" alt="BuildConnect" style="height: 50px; width: auto; margin-right: 10px;">\n                        <span class="white-text brand-font" style="font-weight: 800; font-size: 2rem;">BUILDCONNECT</span><span class="gold-text">.</span>
                    </div>
                    <p class="footer-text">Your trusted platform for connecting with real estate professionals and finding quality products.</p>
                </div>
                <div class="col-md-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-links">
                        <h5>Follow Us</h5>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
<p>&copy; {{ date('Y') }} <span class="gold-text">BuildConnect</span> Real Estate. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
            console.log('Oweru Real Estate loaded!');
            
            // Navbar scroll effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').css('padding', '10px 0');
                } else {
                    $('.navbar').css('padding', '15px 0');
                }
            });
        });
    </script>
</body>
</html>

