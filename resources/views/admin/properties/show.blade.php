@extends('admin.layouts.app')

@section('title', 'Property Details - Oweru Admin')
@section('page-title', 'Property Details: ' . Str::limit($property->title, 30))

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Property Images -->
        <div class="stats-card mb-4">
            <h5 class="mb-4">Property Images</h5>
            <div class="row">
                @php
                    $images = $property->getMedia('property_images');
                @endphp
                
                @forelse($images as $image)
                    <div class="col-md-3 mb-3">
                        <img src="{{ $image->getUrl() }}" alt="Property Image" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No images available</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Property Details -->
        <div class="stats-card">
            <h5 class="mb-4">Property Information</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Title</label>
                    <strong>{{ $property->title }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Price</label>
                    <strong class="text-success">${{ number_format($property->price) }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Property Type</label>
                    <span class="badge-gold">{{ ucfirst($property->property_type) }}</span>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Status</label>
                    @if($property->status == 'available')
                        <span class="badge bg-success">Available</span>
                    @elseif($property->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @else
                        <span class="badge bg-secondary">Sold</span>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Bedrooms</label>
                    <strong>{{ $property->bedrooms ?? 'N/A' }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Bathrooms</label>
                    <strong>{{ $property->bathrooms ?? 'N/A' }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Square Feet</label>
                    <strong>{{ number_format($property->square_feet) ?? 'N/A' }} sqft</strong>
                </div>
                
                <div class="col-12 mb-3">
                    <label class="text-muted d-block">Address</label>
                    <strong>{{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}</strong>
                </div>
                
                <div class="col-12 mb-3">
                    <label class="text-muted d-block">Description</label>
                    <p class="mb-0">{{ $property->description }}</p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Created At</label>
                    <strong>{{ $property->created_at->format('F d, Y h:i A') }}</strong>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted d-block">Last Updated</label>
                    <strong>{{ $property->updated_at->diffForHumans() }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Owner Information -->
        <div class="stats-card text-center mb-4">
            <h5 class="mb-4">Owner Information</h5>
            
            <img src="{{ $property->user->profile_image ?? 'https://via.placeholder.com/100x100/0F172A/F8F8F9?text=' . substr($property->user->name, 0, 1) }}" 
                 alt="{{ $property->user->name }}" 
                 style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--gold-accent); object-fit: cover; margin-bottom: 15px;">
            
            <h5>{{ $property->user->name }}</h5>
            <p class="text-muted">{{ ucfirst($property->user->user_type) }}</p>
            
            <hr>
            
            <div class="text-start">
                <p><i class="fas fa-envelope me-2" style="color: var(--gold-accent);"></i> {{ $property->user->email }}</p>
                <p><i class="fas fa-phone me-2" style="color: var(--gold-accent);"></i> {{ $property->user->phone ?? 'Not provided' }}</p>
            </div>
            
            <a href="{{ route('admin.users.show', $property->user) }}" class="btn btn-gold w-100 mt-3">
                <i class="fas fa-user me-2"></i>View Owner Profile
            </a>
        </div>
        
        <!-- Action Buttons -->
        <div class="stats-card">
            <h5 class="mb-4">Actions</h5>
            
            <div class="d-grid gap-2">
                <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Property
                </a>
                
                <form method="POST" action="{{ route('admin.properties.feature', $property) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas {{ $property->is_featured ? 'fa-star' : 'fa-star-o' }} me-2"></i>
                        {{ $property->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                    </button>
                </form>
                
                <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
                
                <hr>
                
                <form method="POST" action="{{ route('admin.properties.destroy', $property) }}" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Delete Property
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection