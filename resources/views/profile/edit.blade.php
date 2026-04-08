@extends('layouts.app')

@section('title', 'Edit Profile - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <!-- Page Header -->
                    <div class="text-center mb-4">
                        <h1 class="display-6 fw-bold mb-2">Edit <span style="color: var(--brand-gold);">Profile</span></h1>
                        <p class="text-muted">Update your personal information</p>
                    </div>
                    
                    <!-- Profile Image Upload -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="{{ Auth::user()->profile_image_url }}" 
                                 alt="{{ Auth::user()->name }}"
                                 id="profile-preview"
                                 class="rounded-circle"
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--brand-gold);">
                            
                            <form action="{{ route('profile.upload-image') }}" method="POST" enctype="multipart/form-data" id="image-upload-form" class="d-none">
                                @csrf
                                <input type="file" name="profile_image" id="profile-image-input" accept="image/*">
                            </form>
                            
                            <button type="button" class="btn btn-sm position-absolute bottom-0 end-0 rounded-circle p-2" 
                                    onclick="document.getElementById('profile-image-input').click();" 
                                    style="background: var(--brand-gold); border: none; width: 36px; height: 36px;">
                                <i class="fas fa-camera" style="color: var(--brand-dark);"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">Click camera to change profile picture</small>
                    </div>
                    
                    <!-- Display Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Edit Form -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <h5 class="fw-bold mb-3" style="color: var(--brand-dark);">Basic Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly disabled>
                                <small class="text-muted">Email cannot be changed. Contact support if you need to update your email.</small>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Change Password -->
                        <h5 class="fw-bold mb-3" style="color: var(--brand-dark);">Change Password</h5>
                        <p class="small text-muted mb-3">Leave blank if you don't want to change your password</p>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-semibold">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" name="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                        
                        <!-- Professional Information (Only for professionals) -->
                        @if(Auth::user()->user_type == 'professional')
                            <hr class="my-4">
                            
                            <h5 class="fw-bold mb-3" style="color: var(--brand-dark);">Professional Information</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="profession" class="form-label fw-semibold">Profession</label>
                                    <select class="form-select @error('profession') is-invalid @enderror" 
                                            id="profession" name="profession">
                                        <option value="">Select profession</option>
                                        <option value="Architect" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                        <option value="Structural Engineer" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Structural Engineer' ? 'selected' : '' }}>Structural Engineer</option>
                                        <option value="Civil Engineer" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Civil Engineer' ? 'selected' : '' }}>Civil Engineer</option>
                                        <option value="Interior Designer" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Interior Designer' ? 'selected' : '' }}>Interior Designer</option>
                                        <option value="Electrician" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                        <option value="Plumber" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                        <option value="Carpenter" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                                        <option value="Painter" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Painter' ? 'selected' : '' }}>Painter</option>
                                        <option value="Building Contractor" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Building Contractor' ? 'selected' : '' }}>Building Contractor</option>
                                        <option value="Quantity Surveyor" {{ old('profession', Auth::user()->professionalProfile->profession ?? '') == 'Quantity Surveyor' ? 'selected' : '' }}>Quantity Surveyor</option>
                                    </select>
                                    @error('profession')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="years_experience" class="form-label fw-semibold">Years Experience</label>
                                    <input type="number" class="form-control @error('years_experience') is-invalid @enderror" 
                                           id="years_experience" name="years_experience" 
                                           value="{{ old('years_experience', Auth::user()->professionalProfile->years_experience ?? '') }}"
                                           min="0">
                                    @error('years_experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="hourly_rate" class="form-label fw-semibold">Hourly Rate ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                           id="hourly_rate" name="hourly_rate" 
                                           value="{{ old('hourly_rate', Auth::user()->professionalProfile->hourly_rate ?? '') }}"
                                           min="0">
                                    @error('hourly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="bio" class="form-label fw-semibold">Professional Bio</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" 
                                          id="bio" name="bio" rows="4">{{ old('bio', Auth::user()->professionalProfile->bio ?? '') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        
                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 justify-content-end mt-4">
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary px-4 py-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary-custom px-5 py-2">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profile-image-input').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-preview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
        document.getElementById('image-upload-form').submit();
    }
});
</script>

@push('styles')
<style>
    .btn-primary-custom {
        background: var(--brand-gold);
        border: none;
        color: var(--brand-dark);
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-primary-custom:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-1px);
    }
    .form-control, .form-select {
        border: 1px solid var(--gray-300);
        border-radius: 10px;
        padding: 10px 15px;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--brand-gold);
        box-shadow: 0 0 0 3px rgba(201,165,59,0.1);
    }
    .alert-success {
        background: #ecfdf5;
        color: #059669;
        border-left: 4px solid #059669;
    }
    .alert-danger {
        background: #fef2f2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
</style>
@endpush
@endsection