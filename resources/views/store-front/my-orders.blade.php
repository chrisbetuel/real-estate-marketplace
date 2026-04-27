@extends('layouts.app')

@section('title', 'My Orders - Store Front')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-shopping-bag fa-2x me-3" style="color: var(--primary-dark);"></i>
                <div>
                    <h1 class="h3 mb-1" style="color: var(--primary-dark);">My Orders</h1>
                    <p class="mb-0" style="color: var(--gray-600);">Track all your recent purchases</p>
                </div>
            </div>
        </div>
    </div>

    @if($orders->count() > 0)
        @foreach($orders as $order)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card order-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <span class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            <span class="mx-2">•</span>
                            <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                            <span class="badge {{ $order->status_badge }} fs-6 px-3 py-2">
                            {{ $order->status_label }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="order-items">
                                    @foreach($order->items as $item)
                                    <div class="item-row">
                                        <div class="item-image">
                                            <img src="{{ $item->product->images[0] ?? '/placeholder-product.jpg' }}" alt="{{ $item->product->name }}" class="img-fluid">
                                        </div>
                                        <div class="item-details">
                                            <h6 class="item-name">{{ $item->product->name }}</h6>
                                            <p class="item-price">${{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="order-summary">
                                    <div class="total-row">
                                        <span>Total:</span>
                                        <strong>${{ number_format($order->total_amount, 2) }}</strong>
                                    </div>
                                    @if($order->status == \App\Models\OrderStatus::ESCROW_HELD)
                                        <form action="{{ route('orders.confirm-receipt', $order) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Confirm receipt? This will release payment to seller.')">
                                                <i class="fas fa-check me-2"></i>Confirm Receipt
                                            </button>
                                        </form>
                                    @elseif($order->status == 'released')
                                        <a href="{{ route('shop.order-details', $order->id) }}" class="btn btn-outline-success w-100">Order Complete</a>
                                    @elseif($order->driver && in_array($order->delivery_status, ['in_delivery', 'assigned']))
                                        <a href="{{ route('shop.order.track', $order) }}" class="btn btn-primary w-100 mb-1">
                                            <i class="fas fa-map-marker-alt"></i> Track Delivery
                                        </a>
                                        <a href="{{ route('shop.order-details', $order->id) }}" class="btn btn-outline-primary w-100">Details</a>
                                    @else
                                        <a href="{{ route('shop.order-details', $order->id) }}" class="btn btn-outline-primary w-100">View Details</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-12">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-md-8 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-shopping-cart fa-4x mb-4" style="color: var(--gray-400);"></i>
                    <h3 style="color: var(--primary-dark);">No orders yet</h3>
                    <p style="color: var(--gray-600); margin-bottom: 2rem;">Your order history will appear here once you make your first purchase.</p>
                    <a href="{{ route('shop.stores') }}" class="btn" style="background: var(--primary-dark); color: var(--soft-white); padding: 12px 32px; border-radius: 12px;">
                        <i class="fas fa-store me-2"></i>Browse Stores
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.order-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

.order-id {
    font-weight: 600;
    color: var(--primary-dark);
}

.order-date {
    color: var(--gray-600);
    font-size: 0.9rem;
}

.order-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--gray-200);
}

.item-row:last-child {
    border-bottom: none;
}

.item-image img {
    width: 64px;
    height: 64px;
    border-radius: 8px;
    object-fit: cover;
}

.item-name {
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 4px;
}

.item-price {
    color: var(--gray-600);
    margin: 0;
}

.order-summary {
    padding-left: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    font-size: 1.1rem;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--gray-200);
}

.empty-state {
    padding: 3rem 2rem;
}

@media (max-width: 768px) {
    .order-items {
        gap: 16px;
    }
    
    .item-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>
@endpush
@endsection

