@extends('admin.layouts.app')

@section('title', $store->name . ' - Store Details')
@section('page-title', $store->name)

@section('content')
<div class="row">
                <div class="col-md-8">
                    <div class="stats-card">
                        <h5>Store Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $store->logo ? asset('storage/' . $store->logo) : 'https://via.placeholder.com/200x200/F8F8F9/0F172A?text=S' }}" 
                                     alt="{{ $store->name }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @if($store->images && count($store->images) > 0)
                                    <div class="mt-3">
                                        <small class="text-muted">Store Gallery</small>
                                        <div class="d-flex gap-1 mt-1 flex-wrap">
                                            @foreach(array_slice($store->images, 0, 8) as $image)
                                                <img src="{{ asset('storage/' . $image) }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; border: 1px solid var(--light-grey);" title="Store Image">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h3>{{ $store->name }}</h3>
                                @if($store->specialization)
                                    <span class="badge badge-gold">{{ $store->specialization }}</span>
                                @endif
                                @if($store->description)
                                    <p class="mt-2">{{ $store->description }}</p>
                                @endif
                                <p><strong>Owner:</strong> {{ $store->owner->name ?? 'N/A' }}</p>
                                <p><strong>Products:</strong> {{ $store->products_count }}</p>
                                <div class="mt-3">
                                    <span class="badge {{ $store->is_verified ? 'bg-success' : 'bg-warning' }}">
                                        {{ $store->is_verified ? 'Verified' : 'Pending Verification' }}
                                    </span>
                                    <span class="badge {{ $store->is_active ? 'bg-success' : 'bg-secondary' }} ms-2">
                                        {{ $store->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($store->business_hours)
                    <div class="stats-card mt-4">
                        <h5>Business Hours</h5>
                        <div class="row">
                            @foreach($store->business_hours as $day => $hours)
                                <div class="col-md-6 mb-2">
                                    <strong>{{ ucfirst($day) }}:</strong> {{ $hours }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($store->products->count() > 0)
                    <div class="stats-card mt-4">
                        <h5>Recent Products ({{ $store->products_count }})</h5>
                        <div class="row">
                            @foreach($store->products->take(6) as $product)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center p-3">
                                            <h6 class="card-title">{{ Str::limit($product->name, 25) }}</h6>
                                            <p class="text-muted small mb-1">{{ Str::limit($product->description ?? '', 40) }}</p>
                                            <strong>${{ number_format($product->price, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

        <div class="stats-card">
            <h5>Contact Information</h5>
            <ul class="list-unstyled">
                <li><i class="fas fa-map-marker-alt me-2 text-gold"></i>{{ $store->address }}, {{ $store->city }}, {{ $store->state }}</li>
                @if($store->phone)
                    <li><i class="fas fa-phone me-2 text-gold"></i>{{ $store->phone }}</li>
                @endif
                @if($store->email)
                    <li><i class="fas fa-envelope me-2 text-gold"></i>{{ $store->email }}</li>
                @endif
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stats-card">
            <h5>Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list me-2"></i>Back to List
                </a>
                <form method="POST" action="{{ route('admin.stores.toggle-verification', $store) }}" class="d-grid">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $store->is_verified ? 'btn-warning' : 'btn-success' }}">
                        <i class="fas fa-check-circle me-2"></i>{{ $store->is_verified ? 'Revoke Verification' : 'Verify Store' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.stores.destroy', $store) }}" class="d-grid" onsubmit="return confirm('Delete this store?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Store
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

