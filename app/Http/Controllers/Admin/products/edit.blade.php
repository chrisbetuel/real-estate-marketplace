@extends('admin.layouts.app')

@section('title', 'Edit Product - Oweru Admin')
@section('page-title', 'Edit Product: ' . Str::limit($product->name, 30))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="stats-card">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Basic Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing" type="button" role="tab">Pricing</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">Images</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="productTabsContent">
                    <!-- Basic Information Tab -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Store <span class="text-danger">*</span></label>
                                <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                                    @foreach($stores ?? [] as $store)
                                        <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('store_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    <option value="materials" {{ old('category', $product->category) == 'materials' ? 'selected' : '' }}>Materials</option>
                                    <option value="tools" {{ old('category', $product->category) == 'tools' ? 'selected' : '' }}>Tools</option>
                                    <option value="equipment" {{ old('category', $product->category) == 'equipment' ? 'selected' : '' }}>Equipment</option>
                                    <option value="furniture" {{ old('category', $product->category) == 'furniture' ? 'selected' : '' }}>Furniture</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Condition</label>
                                <select name="condition" class="form-select @error('condition') is-invalid @enderror">
                                    <option value="">Select Condition</option>
                                    <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="like_new" {{ old('condition', $product->condition) == 'like_new' ? 'selected' : '' }}>Like New</option>
                                    <option value="good" {{ old('condition', $product->condition) == 'good' ? 'selected' : '' }}>Good</option>
                                    <option value="fair" {{ old('condition', $product->condition) == 'fair' ? 'selected' : '' }}>Fair</option>
                                </select>
                                @error('condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity ?? 1) }}" min="0">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active (visible to users)</label>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Specifications (JSON format)</label>
                                <textarea name="specifications" class="form-control @error('specifications') is-invalid @enderror" rows="4">{{ old('specifications', $product->specifications) }}</textarea>
                                <small class="text-muted">Example: {"color": "Red", "weight": "10kg", "dimensions": "10x10x10"}</small>
                                @error('specifications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing Tab -->
                    <div class="tab-pane fade" id="pricing" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Type <span class="text-danger">*</span></label>
                                <select name="type" id="productType" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="sale" {{ old('type', $product->type) == 'sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="rent" {{ old('type', $product->type) == 'rent' ? 'selected' : '' }}>For Rent</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3" id="salePriceField">
                                <label class="form-label">Sale Price ($)</label>
                                <input type="number" name="price_sale" class="form-control @error('price_sale') is-invalid @enderror" value="{{ old('price_sale', $product->price_sale) }}" min="0" step="0.01">
                                @error('price_sale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3" id="rentPriceField">
                                <label class="form-label">Rent Price ($)</label>
                                <input type="number" name="price_rent" class="form-control @error('price_rent') is-invalid @enderror" value="{{ old('price_rent', $product->price_rent) }}" min="0" step="0.01">
                                @error('price_rent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3" id="rentPeriodField">
                                <label class="form-label">Rent Period</label>
                                <select name="rent_period" class="form-select @error('rent_period') is-invalid @enderror">
                                    <option value="day" {{ old('rent_period', $product->rent_period) == 'day' ? 'selected' : '' }}>Per Day</option>
                                    <option value="week" {{ old('rent_period', $product->rent_period) == 'week' ? 'selected' : '' }}>Per Week</option>
                                    <option value="month" {{ old('rent_period', $product->rent_period) == 'month' ? 'selected' : '' }}>Per Month</option>
                                    <option value="year" {{ old('rent_period', $product->rent_period) == 'year' ? 'selected' : '' }}>Per Year</option>
                                </select>
                                @error('rent_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Images Tab -->
                    <div class="tab-pane fade" id="images" role="tabpanel">
                        <div class="row">
                            <!-- Current Images -->
                            @php
                                $images = $product->getMedia('product_images');
                            @endphp
                            
                            @if($images->count() > 0)
                                <div class="col-12 mb-4">
                                    <label class="form-label">Current Images</label>
                                    <div class="row">
                                        @foreach($images as $image)
                                            <div class="col-md-3 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ $image->getUrl() }}" alt="Product Image" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="deleteImage({{ $image->id }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Upload New Images -->
                            <div class="col-12">
                                <label class="form-label">Add New Images</label>
                                <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                                <small class="text-muted">You can select multiple images. Max 2MB per image.</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <hr>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>View
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productType = document.getElementById('productType');
    const saleField = document.getElementById('salePriceField');
    const rentField = document.getElementById('rentPriceField');
    const rentPeriodField = document.getElementById('rentPeriodField');
    
    function toggleFields() {
        if (productType.value === 'sale') {
            saleField.style.display = 'block';
            rentField.style.display = 'none';
            rentPeriodField.style.display = 'none';
        } else {
            saleField.style.display = 'none';
            rentField.style.display = 'block';
            rentPeriodField.style.display = 'block';
        }
    }
    
    productType.addEventListener('change', toggleFields);
    toggleFields(); // Run on page load
});

function deleteImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch(`/admin/products/image/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to delete image');
            }
        });
    }
}
</script>
@endpush
@endsection