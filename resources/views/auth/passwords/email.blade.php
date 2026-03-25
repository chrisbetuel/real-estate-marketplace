@extends('layouts.app')

@section('title', 'Reset Password - Oweru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 text-center">
                    <i class="fas fa-key fa-3x mb-3" style="color: var(--gold-accent);"></i>
                    <h3 class="mb-0">Reset Password</h3>
                    <p class="text-muted mt-2">Enter your email to receive reset link</p>
                </div>
                
                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope" style="color: var(--gold-accent);"></i>
                                </span>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email') }}" required autofocus
                                       placeholder="Enter your email address">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3" style="background: var(--gold-accent); border: none; color: var(--primary-dark);">
                            <i class="fas fa-paper-plane me-2"></i>Send Password Reset Link
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-dark: #0F172A;
        --gold-accent: #C9A53B;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(201, 165, 59, 0.3);
        background: var(--gold-accent) !important;
    }
    
    .form-control:focus {
        border-color: var(--gold-accent);
        box-shadow: 0 0 0 0.2rem rgba(201, 165, 59, 0.25);
    }
</style>
@endpush
@endsection