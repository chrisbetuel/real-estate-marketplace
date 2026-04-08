@extends('layouts.app')

@section('title', 'Edit Product - Oweru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Product</h5>
                    <p class="text-muted small mb-0">Update your product information</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('store-owner.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price ($) *</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                       value="{{ old('stock', $product->stock) }}" min="0" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                <option value="Building Materials" {{ old('category', $product->category) == 'Building Materials' ? 'selected' : '' }}>Building Materials</option>
                                <option value="Tools" {{ old('category', $product->category) == 'Tools' ? 'selected' : '' }}>Tools</option>
                                <option value="Equipment" {{ old('category', $product->category) == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                                <option value="Furniture" {{ old('category', $product->category) == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="Appliances" {{ old('category', $product->category) == 'Appliances' ? 'selected' : '' }}>Appliances</option>
                                <option value="Decor" {{ old('category', $product->category) == 'Decor' ? 'selected' : '' }}>Decor</option>
                                <option value="Other" {{ old('category', $product->category) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1" 
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label">Active (visible to customers)</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Current Images</label>
                            <div class="row">
                                @php
                                    $images = json_decode($product->images, true);
                                @endphp
                                @if($images && count($images) > 0)
                                    @foreach($images as $image)
                                        <div class="col-md-3 mb-2">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="Product image" 
                                                 style="width: 100%; height: 80px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No images</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Add More Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Add more images to your product gallery.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="5" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('store-owner.products') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-1"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection