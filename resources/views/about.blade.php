<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'About Us - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">About BuildConnect</h1>
            <p class="lead text-muted mb-5">Connecting professionals with clients for exceptional real estate projects.</p>
        </div>
    </div>
    
    <div class="row g-5">
        <div class="col-lg-6">
            <h2 class="h3 mb-4">Our Mission</h2>
            <p class="text-lg">We believe in building better connections in the real estate industry. BuildConnect brings together skilled professionals, store owners, and clients on one platform to make real estate projects smoother and more efficient.</p>
            <p class="text-lg">Whether you're looking for the right professional for your job, products for your store, or clients for your services, we've got you covered.</p>
        </div>
        <div class="col-lg-6">
            <h2 class="h3 mb-4">What We Offer</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-users fa-2x text-brand-gold mb-3"></i>
                            <h5 class="card-title">Professionals</h5>
                            <p class="card-text">Find skilled professionals for your projects.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-store fa-2x text-brand-gold mb-3"></i>
                            <h5 class="card-title">Stores & Products</h5>
                            <p class="card-text">Shop from verified stores and products.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

