@extends('layouts.app')

@section('title', 'Edit Profile - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">Edit <span style="color: var(--gold-accent);">Profile</span></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-5">
                    <!-- Profile Image Upload -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">

                            <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : 'https://via.placeholder.com/150x150/0F172A/F8F8F9?text=' . substr($user->name, 0, 1) }}" 
                                 alt="{{ $user->name }}"
                                 id="profile-preview"

                                 style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid var(--gold-accent);">
                            
                            <form action="{{ route('profile.upload-image') }}" method="POST" enctype="multipart/form-data" id="image-upload-form" class="d-none">
                                @csrf
                                <input type="file" name="profile_image" id="profile-image-input" accept="image/*">
                            </form>
                            
                            <button type="button" class="btn btn-sm position-absolute bottom-0 end-0" onclick="document.getElementById('profile-image-input').click();" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 50%; width: 40px; height: 40px; padding: 0;">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Edit Form -->

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        
                        <!-- Basic Information -->
                        <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">Basic Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold" style="color: var(--primary-dark);">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold" style="color: var(--primary-dark);">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold" style="color: var(--primary-dark);">Email Address</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" readonly disabled
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px; background: #f8f9fa;">
                                <small class="text-muted">Email cannot be changed</small>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label fw-semibold" style="color: var(--primary-dark);">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3"
                                      style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr style="color: var(--light-grey);">
                        
                        <!-- Change Password -->
                        <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">Change Password</h5>
                        <p class="small text-muted mb-3">Leave blank if you don't want to change your password</p>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold" style="color: var(--primary-dark);">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-semibold" style="color: var(--primary-dark);">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" name="new_password"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-semibold" style="color: var(--primary-dark);">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="new_password_confirmation" name="new_password_confirmation"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            </div>
                        </div>
                        
                        @if($user->isProfessional())
                            <hr style="color: var(--light-grey);">
                            
                            <!-- Professional Information -->
                            <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">Professional Information</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="profession" class="form-label fw-semibold" style="color: var(--primary-dark);">Profession</label>
                                    <select class="form-select @error('profession') is-invalid @enderror" 
                                            id="profession" name="profession"
                                            style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                        <option value="">Select profession</option>
                                        <option value="Engineer" {{ old('profession', $user->professionalProfile->profession ?? '') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                        <option value="Architect" {{ old('profession', $user->professionalProfile->profession ?? '') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                        <option value="Designer" {{ old('profession', $user->professionalProfile->profession ?? '') == 'Designer' ? 'selected' : '' }}>Designer</option>
                                        <option value="Electrician" {{ old('profession', $user->professionalProfile->profession ?? '') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                        <option value="Plumber" {{ old('profession', $user->professionalProfile->profession ?? '') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                        <option value="Carpenter" {{ old('profession', $user->professionalProfile->profession ?? '') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                                    </select>
                                    @error('profession')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="years_experience" class="form-label fw-semibold" style="color: var(--primary-dark);">Years Experience</label>
                                    <input type="number" class="form-control @error('years_experience') is-invalid @enderror" 
                                           id="years_experience" name="years_experience" 
                                           value="{{ old('years_experience', $user->professionalProfile->years_experience ?? '') }}"
                                           style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                    @error('years_experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="hourly_rate" class="form-label fw-semibold" style="color: var(--primary-dark);">Hourly Rate ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                           id="hourly_rate" name="hourly_rate" 
                                           value="{{ old('hourly_rate', $user->professionalProfile->hourly_rate ?? '') }}"
                                           style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                    @error('hourly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="bio" class="form-label fw-semibold" style="color: var(--primary-dark);">Professional Bio</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" 
                                          id="bio" name="bio" rows="4"
                                          style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">{{ old('bio', $user->professionalProfile->bio ?? '') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        
                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('profile.show') }}" class="btn btn-lg px-4" style="background: transparent; color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 15px; font-weight: 600;">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-lg px-5" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; font-weight: 600;">
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
        
        // Auto-submit the form
        document.getElementById('image-upload-form').submit();
    }
});
</script>
@endsection