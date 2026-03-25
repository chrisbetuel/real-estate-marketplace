@extends('admin.layouts.app')

@section('title', 'Product Details - Oweru Admin')
@section('page-title', 'Product Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Product Images -->
        <div class="stats-card mb-4">
            <h5 class="mb-4">Product Images</h5>
            <div class="row">
                @php
                    $images = $product->getMedia('product_images');
                @endphp
                
                @forelse($images as $image)
                    <div class="col-md-3 mb-3">
                        <img src="{{ $image->getUrl() }}" alt="Product Image" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No images available</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Product Details -->
        <div class="stats-card">
            <h5 class="mb-4">Product Information</h5>
            
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="text-muted d-block">Product Name</label>
                    <h4>{{ $product->name }}</h4>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Type</label>
                    @if($product->type == 'sale')
                        <span class="badge bg-success">For Sale</span>
                    @else
                        <span class="badge bg-info">For Rent</span>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Category</label>
                    <span class="badge-gold">{{ ucfirst($product->category ?? 'Uncategorized') }}</span>
                </div>
                
                @if($product->type == 'sale')
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Sale Price</label>
                    <h3 class="text-success">${{ number_format($product->price_sale) }}</h3>
                </div>
                @else
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Rent Price</label>
                    <h3 class="text-info">${{ number_format($product->price_rent) }}/{{ $product->rent_period ?? 'month' }}</h3>
                </div>
                @endif
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Quantity Available</label>
                    <strong>{{ $product->quantity ?? 'Unlimited' }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Status</label>
                    @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </div>
                
                @if($product->condition)
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Condition</label>
                    <strong>{{ ucfirst($product->condition) }}</strong>
                </div>
                @endif
                
                <div class="col-12 mb-3">
                    <label class="text-muted d-block">Description</label>
                    <p class="mb-0">{{ $product->description }}</p>
                </div>
                
                @if($product->specifications)
                <div class="col-12 mb-3">
                    <label class="text-muted d-block">Specifications</label>
                    <pre class="mb-0" style="white-space: pre-wrap;">{{ $product->specifications }}</pre>
                </div>
                @endif
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Added Date</label>
                    <strong>{{ $product->created_at->format('F d, Y h:i A') }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Last Updated</label>
                    <strong>{{ $product->updated_at->diffForHumans() }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Store Information -->
        <div class="stats-card text-center mb-4">
            <h5 class="mb-4">Store Information</h5>
            
            @if($product->store)
                <img src="{{ $product->store->logo ?? 'https://via.placeholder.com/100x100/0F172A/F8F8F9?text=' . substr($product->store->name, 0, 1) }}" 
                     alt="{{ $product->store->name }}" 
                     style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--gold-accent); object-fit: cover; margin-bottom: 15px;">
                
                <h5>{{ $product->store->name }}</h5>
                <p class="text-muted">{{ $product->store->email }}</p>
                
                <hr>
                
                <div class="text-start">
                    <p><i class="fas fa-phone me-2" style="color: var(--gold-accent);"></i> {{ $product->store->phone ?? 'Not provided' }}</p>
                    <p><i class="fas fa-map-marker-alt me-2" style="color: var(--gold-accent);"></i> {{ $product->store->address ?? 'Not provided' }}</p>
                </div>
                
                <a href="{{ route('admin.stores.show', $product->store) }}" class="btn btn-gold w-100 mt-3">
                    <i class="fas fa-store me-2"></i>View Store
                </a>
            @else
                <p class="text-muted">No store information available</p>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="stats-card">
            <h5 class="mb-4">Actions</h5>
            
            <div class="d-grid gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </a>
                
                <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas {{ $product->is_active ? 'fa-ban' : 'fa-check' }} me-2"></i>
                        {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
                
                <hr>
                
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection