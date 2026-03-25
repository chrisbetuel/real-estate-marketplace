@extends('layouts.app')

@section('title', 'Register - Oweru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 text-center">
                    <i class="fas fa-user-plus fa-3x mb-3" style="color: var(--gold-accent);"></i>
                    <h3 class="mb-0">Create an Account</h3>
                    <p class="text-muted mt-2">Join the Oweru Real Estate Marketplace</p>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                           required>
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-check-circle"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone') }}">
                                </div>
                                @error('phone')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">User Type *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-briefcase"></i></span>
                                    <select name="user_type" class="form-control @error('user_type') is-invalid @enderror" required>
                                        <option value="">Select User Type</option>
                                        <option value="client" {{ old('user_type') == 'client' ? 'selected' : '' }}>Client (Post Jobs)</option>
                                        <option value="professional" {{ old('user_type') == 'professional' ? 'selected' : '' }}>Professional (Bid on Jobs)</option>
                                        <option value="store_owner" {{ old('user_type') == 'store_owner' ? 'selected' : '' }}>Store Owner (Sell Products)</option>
                                    </select>
                                </div>
                                @error('user_type')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Profile Picture</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-image"></i></span>
                                <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror" 
                                       accept="image/*">
                            </div>
                            <small class="text-muted">Upload a profile picture (JPG, PNG, GIF - Max 2MB)</small>
                            @error('profile_image')
                                <span class="text-danger small d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3" style="background: var(--gold-accent); border: none; color: var(--primary-dark);">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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