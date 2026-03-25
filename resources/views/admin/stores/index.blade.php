@extends('admin.layouts.app')

@section('title', 'Stores Management - Oweru Admin')
@section('page-title', 'Store Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Stores Directory</h4>
            <a href="#" class="btn btn-gold">
                <i class="fas fa-plus me-2"></i>Add New Store
            </a>
        </div>
    </div>
</div>

<div class="stats-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Owner</th>
                    <th>Products</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stores as $store)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $store->logo ? asset('storage/' . $store->logo) : 'https://via.placeholder.com/50x50/F8F8F9/0F172A?text=S' }}" 
                                 alt="{{ $store->name }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <strong>{{ $store->name }}</strong>
                                @if($store->specialization)
                                    <span class="badge badge-gold ms-2">{{ $store->specialization }}</span>
                                @endif
                                <br><small class="text-muted">{{ $store->description ? Str::limit($store->description, 50) : 'No description' }}</small>
                                @if($store->business_hours)
                                    <small class="text-muted d-block mt-1">Hours: {{ collect($store->business_hours)->map(function($hours, $day) { return $day . ': ' . $hours; })->implode(', ') }}</small>
                                @endif
                                @if($store->products->count() > 0)
                                    <div class="mt-1">
                                        <small class="text-muted">Recent products:</small>
                                        @foreach($store->products->take(2) as $product)
                                            <div>{{ Str::limit($product->name, 20) }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $store->owner->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-gold">{{ $store->products_count }}</span>
                    </td>
                    <td>
                        {{ $store->city }}, {{ $store->state }}
                    </td>
                    <td>
                        @if($store->is_verified)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.stores.show', $store) }}" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.stores.toggle-verification', $store) }}" class="d-inline me-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $store->is_verified ? 'btn-warning' : 'btn-success' }}" title="Toggle Verification">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.stores.destroy', $store) }}" class="d-inline" onsubmit="return confirm('Delete store?')">
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
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-store fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No stores found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $stores->links() }}
    </div>
</div>
@endsection

