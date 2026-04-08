@extends('layouts.app')

@section('title', 'My Products - Oweru')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-semibold mb-2">My Products</h1>
                    <p class="text-muted">Manage your product inventory</p>
                </div>
                <a href="{{ route('store-owner.products.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-1"></i>Add New Product
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    32
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Category</th>
                                        <th>Sales</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        32
                                            <td>
                                                @php
                                                    $images = json_decode($product->images, true);
                                                @endphp
                                                @if($images && count($images) > 0)
                                                    <img src="{{ asset('storage/' . $images[0]) }}" 
                                                         alt="{{ $product->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: var(--gray-200); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image" style="color: var(--gray-500);"></i>
                                                    </div>
                                                @endif
                                              \n
                                            <td class="fw-medium">{{ $product->name }}\n
                                            <td class="text-oweru-gold fw-semibold">${{ number_format($product->price, 2) }}\n
                                            <td>{{ $product->stock }}\n
                                            <td>{{ $product->category }}\n
                                            <td>{{ $product->sales_count }}\n
                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('store-owner.products.edit', $product->id) }}" class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('store-owner.products.delete', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $products->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h5>No Products Yet</h5>
                                <p class="text-muted">Start adding products to your store.</p>
                                <a href="{{ route('store-owner.products.create') }}" class="btn btn-primary-custom mt-2">
                                    <i class="fas fa-plus me-1"></i>Add Your First Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-outline-custom {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    .btn-outline-custom:hover {
        border-color: var(--oweru-gold);
        color: var(--oweru-gold);
    }
    .btn-primary-custom {
        background: var(--oweru-gold);
        border: none;
        color: var(--oweru-dark);
        padding: 8px 20px;
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