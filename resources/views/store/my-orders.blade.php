@extends('layouts.app')

@section('title', 'My Store Orders')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-box fa-2x me-3" style="color: var(--gold-accent);"></i>
                <h1 class="h3 mb-1" style="color: var(--primary-dark);">Store Orders</h1>
            </div>
        </div>
    </div>

    @if($orders->count() > 0)
        @foreach($orders as $order)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">#{{ $order->order_number }}</span>
                            <span class="mx-2 text-muted">•</span>
                            <span>{{ $order->created_at->format('M d, Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>From: {{ $order->user->name }}</span>
                        </div>
                        <span class="badge {{ $order->status_badge }} fs-6 px-3 py-2">
                            {{ $order->status_label }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Order Items</h6>
                                @foreach($order->items as $item)
                                <div class="d-flex align-items-center py-2 border-bottom">
                                    <img src="{{ $item->product->images[0] ?? '/placeholder.jpg' }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    <div class="ms-3">
                                        <div>{{ $item->product->name }}</div>
                                        <small class="text-muted">${{ $item->price }} x {{ $item->quantity }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <div class="order-total">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Amount:</span>
                                        <strong>${{ number_format($order->total, 2) }}</strong>
                                    </div>
                                </div>
                                
                                @if($order->status === 'escrow_held')
                                    <form action="{{ route('store.orders.release', $order) }}" method="POST" class="mt-3">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-success w-100 mb-2">
                                            <i class="fas fa-check me-1"></i>Mark as Delivered & Request Payment
                                        </button>
                                    </form>
                                @elseif($order->status === 'pending')
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>Awaiting buyer confirmation
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{ $orders->links() }}
    @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4>No orders yet</h4>
            <p class="text-muted">Orders from your store will appear here.</p>
        </div>
    @endif
</div>
@endsection
