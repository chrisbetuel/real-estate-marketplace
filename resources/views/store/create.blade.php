@extends('layouts.app')

@section('title', 'Register Your Store - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">Register Your <span style="color: var(--gold-accent);">Store</span></h1>
                        <p class="text-muted">Join our marketplace and start selling your products to clients</p>
                    </div>
                    
                    <!-- Form -->
                    <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Store Name -->
                        <div class="mb-4">
                            <label for="store_name" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Name</label>
                            <input type="text" class="form-control @error('store_name') is-invalid @enderror" 
                                   id="store_name" name="store_name" value="{{ old('store_name') }}" 
                                   placeholder="e.g., ABC Hardware Supplies"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('store_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Store Email and Phone -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="store_email" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Email (Optional)</label>
                                <input type="email" class="form-control @error('store_email') is-invalid @enderror" 
                                       id="store_email" name="store_email" value="{{ old('store_email') }}"
                                       placeholder="store@example.com"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('store_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="store_phone" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Phone</label>
                                <input type="text" class="form-control @error('store_phone') is-invalid @enderror" 
                                       id="store_phone" name="store_phone" value="{{ old('store_phone') }}"
                                       placeholder="+1 234 567 8900"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('store_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Store Address -->
                        <div class="mb-4">
                            <label for="store_address" class="form-label fw-semibold" style="color: var(--primary-dark);">Street Address</label>
                            <input type="text" class="form-control @error('store_address') is-invalid @enderror" 
                                   id="store_address" name="store_address" value="{{ old('store_address') }}"
                                   placeholder="123 Main Street"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('store_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- City, State, Postal Code -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="city" class="form-label fw-semibold" style="color: var(--primary-dark);">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city') }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label fw-semibold" style="color: var(--primary-dark);">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                       id="state" name="state" value="{{ old('state') }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="postal_code" class="form-label fw-semibold" style="color: var(--primary-dark);">Postal Code</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Country -->
                        <div class="mb-4">
                            <label for="country" class="form-label fw-semibold" style="color: var(--primary-dark);">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                   id="country" name="country" value="{{ old('country') }}"
                                   placeholder="United States"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Specialization -->
                        <div class="mb-4">
                            <label for="specialization" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Specialization</label>
                            <select class="form-select @error('specialization') is-invalid @enderror" 
                                    id="specialization" name="specialization"
                                    style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                <option value="">Select specialization</option>
                                <option value="Engineer" {{ old('specialization') == 'Engineer' ? 'selected' : '' }}>Engineering Supplies</option>
                                <option value="Architect" {{ old('specialization') == 'Architect' ? 'selected' : '' }}>Architectural Supplies</option>
                                <option value="Electrician" {{ old('specialization') == 'Electrician' ? 'selected' : '' }}>Electrical Supplies</option>
                                <option value="Plumber" {{ old('specialization') == 'Plumber' ? 'selected' : '' }}>Plumbing Supplies</option>
                                <option value="Carpenter" {{ old('specialization') == 'Carpenter' ? 'selected' : '' }}>Carpentry Supplies</option>
                                <option value="Painter" {{ old('specialization') == 'Painter' ? 'selected' : '' }}>Painting Supplies</option>
                                <option value="General" {{ old('specialization') == 'General' ? 'selected' : '' }}>General Hardware</option>
                            </select>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4"
                                      placeholder="Tell clients about your store and what you offer...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Logo Upload -->
                        <div class="mb-4">
                            <label for="logo" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            <small class="text-muted">Upload a square image for best results (max 2MB)</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Business Hours -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Business Hours</label>
                            <div class="row g-2">
                                @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                @endphp
                                
                                @foreach($days as $day)
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">{{ $day }}</label>
                                    <input type="text" class="form-control" name="business_hours[{{ $day }}]" 
                                           placeholder="e.g., 9:00 AM - 6:00 PM"
                                           style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 10px;">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-lg" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 15px; font-weight: 600;">
                                <i class="fas fa-store me-2"></i>Register Store
                            </button>
                            <a href="{{ route('stores.index') }}" class="btn btn-lg" style="background: transparent; color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 15px; padding: 15px; font-weight: 600;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection