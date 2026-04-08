@extends('layouts.app')

@section('title', 'Shopping Cart - Oweru')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-semibold mb-2">Shopping Cart</h1>
            <p class="text-muted">Review and manage your items</p>
        </div>
    </div>

    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-cart mb-0">
                                <thead>
                                    32
                                        <th style="width: 40%">Product</th>
                                        <th style="width: 20%">Price</th>
                                        <th style="width: 25%">Quantity</th>
                                        <th style="width: 15%">Total</th>
                                    </thead>
                                    <tbody id="cart-items">
                                        @foreach($cartItems as $item)
                                            <tr id="cart-item-{{ $item->id }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $images = json_decode($item->product->images, true);
                                                        @endphp
                                                        @if($images && count($images) > 0)
                                                            <img src="{{ asset('storage/' . $images[0]) }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                                        @else
                                                            <div style="width: 60px; height: 60px; background: var(--gray-200); border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-image" style="color: var(--gray-500);"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                            <p class="text-muted small mb-0">{{ $item->product->store->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="product-price" data-price="{{ $item->product->price }}">
                                                    ${{ number_format($item->product->price, 2) }}
                                                </td>
                                                <td>
                                                    <div class="quantity-selector d-flex align-items-center">
                                                        <button type="button" class="btn-quantity btn-minus" data-id="{{ $item->id }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="quantity-input" 
                                                               data-id="{{ $item->id }}"
                                                               data-stock="{{ $item->product->stock }}"
                                                               value="{{ $item->quantity }}" 
                                                               min="1" 
                                                               max="{{ $item->product->stock }}">
                                                        <button type="button" class="btn-quantity btn-plus" data-id="{{ $item->id }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="item-total fw-semibold" data-id="{{ $item->id }}">
                                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn-remove" data-id="{{ $item->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (7%):</span>
                                <span id="tax">${{ number_format($tax, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong class="text-oweru-gold fs-5" id="total">${{ number_format($total, 2) }}</strong>
                            </div>
                            <a href="{{ route('shop.checkout') }}" class="btn btn-primary-custom w-100">
                                Proceed to Checkout
                            </a>
                            <a href="{{ route('shop.products') }}" class="btn btn-outline-custom w-100 mt-2">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h5>Your cart is empty</h5>
                <p class="text-muted">Browse our products and add items to your cart.</p>
                <a href="{{ route('shop.products') }}" class="btn btn-primary-custom mt-2">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .table-cart th {
        background: var(--gray-100);
        padding: 15px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .table-cart td {
        padding: 15px;
        vertical-align: middle;
    }
    
    .quantity-selector {
        gap: 8px;
    }
    
    .btn-quantity {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--gray-300);
        background: var(--white);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-quantity:hover {
        border-color: var(--oweru-gold);
        color: var(--oweru-gold);
    }
    
    .quantity-input {
        width: 60px;
        text-align: center;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 6px 0;
        font-size: 0.9rem;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: var(--oweru-gold);
    }
    
    .btn-remove {
        background: none;
        border: none;
        color: var(--gray-500);
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .btn-remove:hover {
        color: var(--danger);
    }
    
    .btn-primary-custom {
        background: var(--oweru-gold);
        border: none;
        color: var(--oweru-dark);
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: var(--oweru-gold-dark);
        transform: translateY(-1px);
    }
    
    .btn-outline-custom {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-outline-custom:hover {
        border-color: var(--oweru-gold);
        color: var(--oweru-gold);
    }
</style>
@endpush

@push('scripts')
<script>
    // Update cart item quantity
    function updateCartItem(cartId, quantity) {
        fetch(`/shop/cart/update/${cartId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the item total
                const itemTotalCell = document.querySelector(`.item-total[data-id="${cartId}"]`);
                if (itemTotalCell) {
                    itemTotalCell.textContent = '$' + data.item_total;
                }
                
                // Update totals
                document.getElementById('subtotal').textContent = '$' + data.subtotal;
                document.getElementById('tax').textContent = '$' + data.tax;
                document.getElementById('total').textContent = '$' + data.total;
            }
        });
    }
    
    // Remove cart item
    function removeCartItem(cartId) {
        fetch(`/shop/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row
                const row = document.getElementById(`cart-item-${cartId}`);
                if (row) {
                    row.remove();
                }
                
                // Update totals
                document.getElementById('subtotal').textContent = '$' + data.subtotal;
                document.getElementById('tax').textContent = '$' + data.tax;
                document.getElementById('total').textContent = '$' + data.total;
                
                // If cart is empty, reload page
                if (data.cart_count === 0) {
                    location.reload();
                }
            }
        });
    }
    
    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity minus buttons
        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.id;
                const input = document.querySelector(`.quantity-input[data-id="${cartId}"]`);
                if (input && parseInt(input.value) > 1) {
                    const newValue = parseInt(input.value) - 1;
                    input.value = newValue;
                    updateCartItem(cartId, newValue);
                }
            });
        });
        
        // Quantity plus buttons
        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.id;
                const input = document.querySelector(`.quantity-input[data-id="${cartId}"]`);
                const maxStock = parseInt(input.dataset.stock);
                if (input && parseInt(input.value) < maxStock) {
                    const newValue = parseInt(input.value) + 1;
                    input.value = newValue;
                    updateCartItem(cartId, newValue);
                }
            });
        });
        
        // Quantity input change
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const cartId = this.dataset.id;
                let newValue = parseInt(this.value);
                const maxStock = parseInt(this.dataset.stock);
                
                if (isNaN(newValue) || newValue < 1) {
                    newValue = 1;
                    this.value = 1;
                } else if (newValue > maxStock) {
                    newValue = maxStock;
                    this.value = maxStock;
                }
                
                updateCartItem(cartId, newValue);
            });
        });
        
        // Remove buttons
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.id;
                if (confirm('Remove this item from cart?')) {
                    removeCartItem(cartId);
                }
            });
        });
    });
</script>
@endpush
@endsection