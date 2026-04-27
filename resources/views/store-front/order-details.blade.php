@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - Oweru')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('shop.my-orders') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Orders
            </a>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-1" style="color: var(--primary-dark);">Order #{{ $order->order_number }}</h1>
                    <p class="mb-0 text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <span class="badge {{ $order->status_badge }} fs-5 px-4 py-2">
                    {{ $order->status_label }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 fw-semibold">Order Items ({{ $order->items->count() }})</h6>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="item-row d-flex align-items-center py-3 border-bottom">
                        <div class="item-image me-3">
                            <img src="{{ $item->product->first_image ?? asset('images/no-image.png') }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <p class="text-muted small mb-1">From {{ $order->store->name }}</p>
                            <p>${{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                        </div>
                        <div class="text-end">
                            <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-truck me-2"></i>Delivery Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Shipping Address:</strong><br>
                            {{ $order->shipping_address['address'] ?? 'N/A' }}<br>
                            {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zip_code'] ?? '' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            @if($order->driver)
                                <strong>Driver:</strong><br>
                                <span class="fw-semibold">{{ $order->driver->user->name }}</span> ({{ $order->driver->vehicle_label }})<br>
                                <small class="text-muted">{{ $order->delivery_status ? ucfirst($order->delivery_status) : 'Pending' }}</small>
                                @if($order->delivery_status == 'in_delivery' || $order->driver->is_available)
                                    <div class="mt-3">
                                        <a href="{{ route('shop.order.track', $order) }}" class="btn btn-primary">
                                            <i class="fas fa-map-marker-alt me-1"></i>Track Delivery Live
                                        </a>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">No driver assigned yet</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 fw-semibold">Order Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (7%):</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Delivery:</span>
                        <span>${{ number_format($order->delivery_price ?? 0, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 h5">
                        <span>Total:</span>
                        <strong>${{ number_format($order->total, 2) }}</strong>
                    </div>

                    @if($order->escrowHold && $order->status == 'escrow_held')
                        <div class="alert alert-warning">
                            <i class="fas fa-shield-alt me-2"></i>
                            Funds held securely in escrow until you confirm receipt.
                        </div>
                        <form method="POST" action="{{ route('shop.orders.confirm-receipt', $order) }}" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Confirm you received the order? This releases payment to the seller.')">
                                <i class="fas fa-check-circle me-2"></i>Confirm Receipt & Release Payment
                            </button>
                        </form>
                    @elseif($order->status == 'released')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>Payment released ✓ Order complete
                        </div>
                    @endif

                    <a href="{{ route('shop.my-orders') }}" class="btn btn-outline-secondary w-100">
                        View All Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.item-row {
    border-bottom: 1px solid var(--gray-200);
}
.item-row:last-child {
    border-bottom: none;
}
.sticky-top {
    position: sticky;
}
</style>
@endpush
