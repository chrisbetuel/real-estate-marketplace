@extends('layouts.app')

@section('title', 'List Product - Real Estate Marketplace')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">List New Product</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Product Type</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select type</option>
                                    <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>For Sale Only</option>
                                    <option value="rent" {{ old('type') == 'rent' ? 'selected' : '' }}>For Rent Only</option>
                                    <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both Sale and Rent</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3" id="sale_price_div">
                                <label for="price_sale" class="form-label">Sale Price ($)</label>
                                <input type="number" step="0.01" class="form-control @error('price_sale') is-invalid @enderror" 
                                       id="price_sale" name="price_sale" value="{{ old('price_sale') }}">
                                @error('price_sale')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3" id="rent_price_div">
                                <label for="price_rent" class="form-label">Rent Price ($)</label>
                                <input type="number" step="0.01" class="form-control @error('price_rent') is-invalid @enderror" 
                                       id="price_rent" name="price_rent" value="{{ old('price_rent') }}">
                                @error('price_rent')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3" id="rent_period_div">
                                <label for="rent_period" class="form-label">Rent Period</label>
                                <select class="form-select @error('rent_period') is-invalid @enderror" id="rent_period" name="rent_period">
                                    <option value="">Select period</option>
                                    <option value="daily" {{ old('rent_period') == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('rent_period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('rent_period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                                @error('rent_period')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                                @error('quantity')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="images" class="form-label">Product Images</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                   id="images" name="images[]" multiple accept="image/*" required>
                            <small class="text-muted">You can select multiple images (Max 10)</small>
                            @error('images')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            @error('images.*')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="specifications" class="form-label">Specifications (Optional)</label>
                            <div id="specs">
                                <div class="row mb-2">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="specifications[value][]" placeholder="Value">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addSpec()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">List Product</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addSpec() {
    const div = document.createElement('div');
    div.className = 'row mb-2';
    div.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="specifications[value][]" placeholder="Value">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">-</button>
        </div>
    `;
    document.getElementById('specs').appendChild(div);
}

// Show/hide price fields based on product type
document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const saleDiv = document.getElementById('sale_price_div');
    const rentDiv = document.getElementById('rent_price_div');
    const periodDiv = document.getElementById('rent_period_div');
    
    if (type === 'sale') {
        saleDiv.style.display = 'block';
        rentDiv.style.display = 'none';
        periodDiv.style.display = 'none';
    } else if (type === 'rent') {
        saleDiv.style.display = 'none';
        rentDiv.style.display = 'block';
        periodDiv.style.display = 'block';
    } else if (type === 'both') {
        saleDiv.style.display = 'block';
        rentDiv.style.display = 'block';
        periodDiv.style.display = 'block';
    }
});

// Trigger on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('type').dispatchEvent(new Event('change'));
});
</script>
@endsection