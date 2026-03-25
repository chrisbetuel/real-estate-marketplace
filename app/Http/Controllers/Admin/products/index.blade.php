@extends('admin.layouts.app')

@section('title', 'Products Management - Oweru Admin')
@section('page-title', 'Products Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="stats-card">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="materials" {{ request('category') == 'materials' ? 'selected' : '' }}>Materials</option>
                        <option value="tools" {{ request('category') == 'tools' ? 'selected' : '' }}>Tools</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="furniture" {{ request('category') == 'furniture' ? 'selected' : '' }}>Furniture</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5>All Products</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-gold">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Store</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $product)
                        <tr>
                            <td>#{{ $product->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->getFirstMediaUrl('product_images'))
                                        <img src="{{ $product->getFirstMediaUrl('product_images', 'thumb') }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 50px; height: 50px; border-radius: 10px; margin-right: 10px; object-fit: cover;">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 10px; margin-right: 10px; background: var(--light-grey); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-cube" style="color: var(--primary-dark);"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ Str::limit($product->name, 30) }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->store)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->store->logo ?? 'https://via.placeholder.com/30x30/0F172A/F8F8F9?text=S' }}" 
                                             alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px; object-fit: cover;">
                                        <strong>{{ Str::limit($product->store->name, 15) }}</strong>
                                    </div>
                                @else
                                    <span class="text-muted">No Store</span>
                                @endif
                            </td>
                            <td>
                                @if($product->type == 'sale')
                                    <span class="badge bg-success">For Sale</span>
                                @else
                                    <span class="badge bg-info">For Rent</span>
                                @endif
                            </td>
                            <td>
                                @if($product->type == 'sale')
                                    <strong>${{ number_format($product->price_sale) }}</strong>
                                @else
                                    <strong>${{ number_format($product->price_rent) }}/{{ $product->rent_period ?? 'mo' }}</strong>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                                <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                                <p>No products found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $products->links() ?? '' }}
            </div>
        </div>
    </div>
</div>
@endsection