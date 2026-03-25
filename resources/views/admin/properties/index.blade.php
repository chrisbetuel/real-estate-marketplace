@extends('admin.layouts.app')

@section('title', 'Properties Management - Oweru Admin')
@section('page-title', 'Properties Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="stats-card">
            <form method="GET" action="{{ route('admin.properties.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by title, description or address..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="property_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                        <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="condo" {{ request('property_type') == 'condo' ? 'selected' : '' }}>Condo</option>
                        <option value="townhouse" {{ request('property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.properties.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Add Property
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="stats-card">
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Property</th>
                            <th>Owner</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $property)
                        <tr>
                            <td>#{{ $property->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($property->getFirstMediaUrl('property_images'))
                                        <img src="{{ $property->getFirstMediaUrl('property_images', 'thumb') }}" 
                                             alt="{{ $property->title }}" 
                                             style="width: 50px; height: 50px; border-radius: 10px; margin-right: 10px; object-fit: cover;">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 10px; margin-right: 10px; background: var(--light-grey); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-building" style="color: var(--primary-dark);"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ Str::limit($property->title, 30) }}</strong>
                                        <div><small class="text-muted">ID: {{ $property->id }}</small></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $property->user->profile_image ?? 'https://via.placeholder.com/30x30/0F172A/F8F8F9?text=' . substr($property->user->name, 0, 1) }}" 
                                         alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px; object-fit: cover;">
                                    <div>
                                        <strong>{{ Str::limit($property->user->name, 15) }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td><strong>${{ number_format($property->price) }}</strong></td>
                            <td>
                                <i class="fas fa-map-marker-alt me-1" style="color: var(--gold-accent);"></i>
                                {{ $property->city }}, {{ $property->state }}
                            </td>
                            <td>
                                <span class="badge-gold">{{ ucfirst($property->property_type) }}</span>
                            </td>
                            <td>
                                @if($property->status == 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($property->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">Sold</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.properties.show', $property) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.properties.feature', $property) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" title="{{ $property->is_featured ? 'Unfeature' : 'Feature' }}">
                                            <i class="fas {{ $property->is_featured ? 'fa-star' : 'fa-star-o' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.properties.destroy', $property) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                <p>No properties found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $properties->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection