<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Our Team - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">Meet Our Team</h1>
            <p class="lead text-muted mb-5">The people behind BuildConnect who make it all happen.</p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body p-4">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="card-title">John Doe</h5>
                    <p class="text-muted mb-3">CEO & Founder</p>
                    <p class="small text-muted">Visionary leader with 15+ years in real estate technology.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body p-4">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="card-title">Jane Smith</h5>
                    <p class="text-muted mb-3">CTO</p>
                    <p class="small text-muted">Tech expert specializing in scalable web applications.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body p-4">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="card-title">Mike Johnson</h5>
                    <p class="text-muted mb-3">Head of Operations</p>
                    <p class="small text-muted">Ensuring smooth operations and customer satisfaction.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

