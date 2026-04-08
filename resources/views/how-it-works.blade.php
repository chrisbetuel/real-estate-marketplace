<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'How It Works - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">How It Works</h1>
            <p class="lead text-muted mb-5">Simple steps to get your project done right.</p>
        </div>
    </div>
    
    <div class="row g-5">
        <div class="col-lg-4">
            <div class="text-center p-5 bg-light rounded-4">
                <div class="bg-brand-gold text-white rounded-circle d-block mx-auto mb-4 p-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-2x fa-briefcase"></i>
                </div>
                <h3 class="h4 fw-bold mb-3">1. Post Your Job</h3>
                <p class="text-muted">Describe your project and requirements. Get matched with qualified professionals.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="text-center p-5 bg-light rounded-4">
                <div class="bg-brand-gold text-white rounded-circle d-block mx-auto mb-4 p-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-2x fa-gavel"></i>
                </div>
                <h3 class="h4 fw-bold mb-3">2. Receive Bids</h3>
                <p class="text-muted">Review bids from professionals, check profiles, and choose the best fit.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="text-center p-5 bg-light rounded-4">
                <div class="bg-brand-gold text-white rounded-circle d-block mx-auto mb-4 p-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-2x fa-check-circle"></i>
                </div>
                <h3 class="h4 fw-bold mb-3">3. Complete Project</h3>
                <p class="text-muted">Secure payments with escrow, track progress, and complete your project successfully.</p>
            </div>
        </div>
    </div>
</div>
@endsection>

