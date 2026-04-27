@extends('layouts.app')

@section('title', 'Add Product - Oweru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add New Product</h5>
                    <p class="text-muted small mb-0">List your product for sale</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('store-owner.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price ($) *</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" step="0.01" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                       value="{{ old('stock', 10) }}" min="0" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                <option value="Building Materials" {{ old('category') == 'Building Materials' ? 'selected' : '' }}>Building Materials</option>
                                <option value="Tools" {{ old('category') == 'Tools' ? 'selected' : '' }}>Tools</option>
                                <option value="Equipment" {{ old('category') == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                                <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="Appliances" {{ old('category') == 'Appliances' ? 'selected' : '' }}>Appliances</option>
                                <option value="Decor" {{ old('category') == 'Decor' ? 'selected' : '' }}>Decor</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product Images</label>
                            <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" 
                                   multiple accept="image/*">
                            <small class="text-muted">You can select multiple images. Max 2MB each.</small>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('store-owner.products') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-primary-custom {
        background: var(--oweru-gold);
        border: none;
        color: var(--oweru-dark);
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-primary-custom:hover {
        background: var(--oweru-gold-dark);
        transform: translateY(-1px);
    }
</style>
@endpush
@endsection