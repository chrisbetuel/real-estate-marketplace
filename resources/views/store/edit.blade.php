@extends('layouts.app')

@section('title', 'Edit Store - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">Edit Your <span style="color: var(--gold-accent);">Store</span></h1>
                        <p class="text-muted">Update your store information</p>
                    </div>
                    
                    <!-- Form -->
                    <form action="{{ route('stores.update', $store) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Store Name -->
                        <div class="mb-4">
                            <label for="store_name" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Name</label>
                            <input type="text" class="form-control @error('store_name') is-invalid @enderror" 
                                   id="store_name" name="store_name" value="{{ old('store_name', $store->store_name) }}" 
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('store_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Store Email and Phone -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="store_email" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Email</label>
                                <input type="email" class="form-control @error('store_email') is-invalid @enderror" 
                                       id="store_email" name="store_email" value="{{ old('store_email', $store->store_email) }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('store_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="store_phone" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Phone</label>
                                <input type="text" class="form-control @error('store_phone') is-invalid @enderror" 
                                       id="store_phone" name="store_phone" value="{{ old('store_phone', $store->store_phone) }}"
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
                                   id="store_address" name="store_address" value="{{ old('store_address', $store->store_address) }}"
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
                                       id="city" name="city" value="{{ old('city', $store->city) }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label fw-semibold" style="color: var(--primary-dark);">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                       id="state" name="state" value="{{ old('state', $store->state) }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="postal_code" class="form-label fw-semibold" style="color: var(--primary-dark);">Postal Code</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code', $store->postal_code) }}"
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
                                   id="country" name="country" value="{{ old('country', $store->country) }}"
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
                                <option value="Engineer" {{ old('specialization', $store->specialization) == 'Engineer' ? 'selected' : '' }}>Engineering Supplies</option>
                                <option value="Architect" {{ old('specialization', $store->specialization) == 'Architect' ? 'selected' : '' }}>Architectural Supplies</option>
                                <option value="Electrician" {{ old('specialization', $store->specialization) == 'Electrician' ? 'selected' : '' }}>Electrical Supplies</option>
                                <option value="Plumber" {{ old('specialization', $store->specialization) == 'Plumber' ? 'selected' : '' }}>Plumbing Supplies</option>
                                <option value="Carpenter" {{ old('specialization', $store->specialization) == 'Carpenter' ? 'selected' : '' }}>Carpentry Supplies</option>
                                <option value="Painter" {{ old('specialization', $store->specialization) == 'Painter' ? 'selected' : '' }}>Painting Supplies</option>
                                <option value="General" {{ old('specialization', $store->specialization) == 'General' ? 'selected' : '' }}>General Hardware</option>
                            </select>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold" style="color: var(--primary-dark);">Store Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $store->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Logo Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Store Logo</label>
                            @if($store->logo)
                            <div class="mb-2">
                                <img src="{{ $store->logo }}" alt="Current logo" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   name="logo" accept="image/*"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            <small class="text-muted">Leave empty to keep current logo (JPG, PNG up to 2MB)</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Store Gallery Images -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Store Product Pictures (Gallery)</label>
                            @if($store->images && count($store->images) > 0)
                                <div class="row mb-3">
                                    @foreach($store->images as $image)
                                        <div class="col-md-3 mb-2">
                                            <img src="{{ $image }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                   name="images[]" multiple accept="image/*" 
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            <small class="text-muted">Upload multiple pictures of products in your store (JPG, PNG up to 2MB each)</small>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-lg" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 15px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Update Store
                            </button>
                            <a href="{{ route('stores.show', $store) }}" class="btn btn-lg" style="background: transparent; color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 15px; padding: 15px; font-weight: 600;">
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