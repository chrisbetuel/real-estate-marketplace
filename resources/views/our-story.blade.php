<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Our Story - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">Our Story</h1>
            <p class="lead text-muted mb-5">From a simple idea to the leading real estate connection platform.</p>
        </div>
    </div>
    
    <div class="row g-5">
        <div class="col-lg-6 order-lg-2">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="BuildConnect Story" class="img-fluid rounded-4 shadow-lg">
        </div>
        <div class="col-lg-6 order-lg-1">
            <h2 class="h3 mb-4">How It All Started</h2>
            <p class="text-lg">BuildConnect was born from the frustration of finding reliable professionals and quality products for real estate projects. Our founders saw the gap in the market and created a platform that brings everyone together.</p>
            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-4">
                <div class="bg-brand-gold text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-lightbulb fa-lg"></i>
                </div>
                <div>
                    <h5 class="mb-1">2022</h5>
                    <p class="mb-0 text-muted">Founded with a vision to simplify real estate connections.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

