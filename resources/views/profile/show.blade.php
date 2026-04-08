@extends('layouts.app')

@section('title', 'My Profile - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">My <span style="color: var(--gold-accent);">Profile</span></h1>
        </div>
    </div>

    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; overflow: hidden;">
                <div class="card-body text-center p-4">
    <div class="text-center mb-4">
        <img src="{{ $user->profile_image_url }}" 
             alt="{{ $user->name }}" 
             class="rounded-circle img-fluid" 
             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--gold-accent);">
        <h3 class="mt-3">{{ $user->name }}</h3>
        <p class="text-muted">{{ ucfirst($user->user_type) }}</p>
    </div>
                    
                    <!-- Edit Profile Button -->
                    <a href="{{ route('profile.edit') }}" class="btn w-100 mb-2" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 12px; font-weight: 600;">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                    
@if($user->user_type == 'professional' && $user->professionalProfile)
                        <a href="{{ route('professional.dashboard') }}" class="btn w-100" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-briefcase me-2"></i>Professional Dashboard
                        </a>
                    @elseif($user->isStoreOwner() && $user->store)
                        <a href="{{ route('stores.edit', $user->store) }}" class="btn w-100" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-store me-2"></i>Manage Store
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-md-8">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Profile Updated!</strong> Your changes have been saved successfully. 
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <h5 class="fw-bold mb-4" style="color: var(--primary-dark);">Profile Information</h5>
                    
                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3" style="color: var(--gold-accent);">Contact Information</h6>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p class="small text-muted mb-1">Full Name</p>
                                <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-1">Email Address</p>
                                <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->email }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-1">Phone Number</p>
                                <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <p class="small text-muted mb-1">Address</p>
                                <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->address ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr style="color: var(--light-grey);">
                    
                    <!-- Account Information -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3" style="color: var(--gold-accent);">Account Information</h6>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p class="small text-muted mb-1">Member Since</p>
                                <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-1">Account Status</p>
                                <p class="fw-semibold" style="color: {{ $user->is_active ? '#28a745' : '#dc3545' }};">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-1">Verification Status</p>
                                <p class="fw-semibold" style="color: {{ $user->is_verified ? '#28a745' : '#dc3545' }};">
                                    {{ $user->is_verified ? 'Verified' : 'Unverified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->isProfessional() && $user->professionalProfile)
                        <hr style="color: var(--light-grey);">
                        
                        <!-- Professional Information -->
                        <div>
                            <h6 class="fw-semibold mb-3" style="color: var(--gold-accent);">Professional Information</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <p class="small text-muted mb-1">Profession</p>
                                    <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->professionalProfile->profession }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="small text-muted mb-1">Years Experience</p>
                                    <p class="fw-semibold" style="color: var(--primary-dark);">{{ $user->professionalProfile->years_experience ?? 'Not specified' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="small text-muted mb-1">Hourly Rate</p>
                                    <p class="fw-semibold" style="color: var(--primary-dark);">${{ $user->professionalProfile->hourly_rate ?? '0' }}/hr</p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <p class="small text-muted mb-1">Bio</p>
                                <p style="color: var(--primary-dark); opacity: 0.8;">{{ $user->professionalProfile->bio ?? 'No bio provided' }}</p>
                            </div>
                            
                            @if($user->professionalProfile->qualifications)
                            <div class="mb-3">
                                <p class="small text-muted mb-1">Qualifications</p>
                                <div>
                                    @foreach($user->professionalProfile->qualifications as $qualification)
                                        <span class="badge me-1" style="background: var(--primary-dark); color: var(--soft-white); padding: 5px 15px; border-radius: 50px;">{{ $qualification }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection