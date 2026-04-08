@extends('layouts.app')

@section('title', 'Checkout - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.cart') }}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background: var(--primary-dark); color: var(--soft-white);">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Order Summary
                    </h4>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex align-items-center py-3 border-bottom">
                        <img src="{{ $item->product->images[0] ?? 'https://via.placeholder.com/80x80' }}" 
                             alt="{{ $item->product->name }}" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                        </div>
                        <div class="text-end">
${{ number_format($item->product->price_sale ?? $item->product->price_rent ?? $item->product->price ?? 0, 2) }}
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="h5">Total:</span>
                        <span class="h4">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header" style="background: var(--primary-dark); color: var(--soft-white);">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h5>
                </div>
                <div class="card-body">
                    <form id="shippingForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="{{ $user->first_name ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="{{ $user->last_name ?? '' }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" placeholder="Street address" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header" style="background: var(--gold-accent); color: var(--primary-dark);">
                    <h5 class="mb-0"><i class="fas fa-wallet me-2"></i>Payment</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 p-3" style="background: var(--light-grey); border-radius: 10px;">
                        <small class="text-muted">Wallet Balance</small>
                        <div class="d-flex justify-content-between">
                            <span>Available:</span>
                            <strong>${{ number_format($walletBalance, 2) }}</strong>
                        </div>
                    </div>

                    @if($total > $walletBalance)
                    <div class="alert alert-warning">
                        Insufficient wallet balance. Please top up your wallet.
                    </div>
                    @endif

                    <button id="placeOrderBtn" class="btn w-100 btn-lg" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px;" 
                            {{ $total > $walletBalance ? 'disabled' : '' }}>
                        <i class="fas fa-shield-alt me-2"></i>
                        Place Order - ${{ number_format($total, 2) }} (Funds held in Escrow)
                    </button>
                    <div class="mt-3 p-3" style="background: #f8f9ff; border-left: 4px solid var(--primary-dark); border-radius: 8px;">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Secure Escrow:</strong> Your funds will be held securely until you confirm receipt. Seller only receives payment after delivery.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('placeOrderBtn').addEventListener('click', function() {
    if (!this.disabled) {
        if (confirm('Confirm order placement?')) {
            // Submit form or AJAX to processOrder
            window.location.href = '{{ route("shop.process-order") }}';
        }
    }
});
</script>
@endsection

