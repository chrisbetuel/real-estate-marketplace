{{-- resources/views/admin/profile/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Profile - Oweru Admin')
@section('page-title', 'My Profile')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="mb-4">
                <img src="{{ Auth::guard('admin')->user()->profile_image_url }}" 
                     alt="Profile" style="width: 150px; height: 150px; border-radius: 50%; border: 4px solid var(--gold-accent);">
            </div>
            
            <h4 class="mb-2">{{ Auth::guard('admin')->user()->name }}</h4>
            <p class="text-muted mb-3">
                <span class="badge-gold">{{ ucfirst(Auth::guard('admin')->user()->role) }}</span>
            </p>
            
            <hr>
            
            <div class="text-start mt-3">
                <p><i class="fas fa-envelope me-2" style="color: var(--gold-accent);"></i> {{ Auth::guard('admin')->user()->email }}</p>
                <p><i class="fas fa-phone me-2" style="color: var(--gold-accent);"></i> {{ Auth::guard('admin')->user()->phone ?? 'Not provided' }}</p>
                <p><i class="fas fa-clock me-2" style="color: var(--gold-accent);"></i> Last Login: {{ Auth::guard('admin')->user()->last_login_at?->diffForHumans() ?? 'First login' }}</p>
                <p><i class="fas fa-network-wired me-2" style="color: var(--gold-accent);"></i> Last IP: {{ Auth::guard('admin')->user()->last_login_ip ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="stats-card">
            <h5 class="mb-4">Edit Profile</h5>
            
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::guard('admin')->user()->phone }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                        <small class="text-muted">Leave blank if you don't want to change password</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection