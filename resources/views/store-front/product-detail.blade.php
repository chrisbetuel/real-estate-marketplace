@extends('layouts.app')

@section('title', $product->name . ' - Oweru')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Product Images -->
            <div class="card">
                <div class="card-body text-center">
                    <img id="main-image" src="{{ $product->first_image }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded"
                         style="max-height: 400px; width: auto;"
                         onerror="this.src='{{ asset('images/no-image.png') }}';">
                    @if(!empty($product->images) && count($product->images) > 1)
                        <div class="row mt-3">
                            @foreach($product->images as $image)
                                <div class="col-3">
                                    <img src="{{ is_string($image) ? asset('storage/' . $image) : ($image['url'] ?? asset('images/no-image.png')) }}" 
                                         alt="Thumbnail" 
                                         class="img-fluid rounded cursor-pointer"
                                         style="height: 70px; width: 100%; object-fit: cover; cursor: pointer;"
                                         onclick="document.getElementById('main-image').src = this.src">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if(empty($product->images))
                        <div style="height: 300px; background: var(--gray-200); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image fa-4x" style="color: var(--gray-500);"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h2 mb-3">{{ $product->name }}</h1>
                    <p class="text-oweru-gold fs-3 fw-bold">${{ number_format($product->price, 2) }}</p>
                    
                    <div class="mb-3">
                        @if($product->quantity > 0)
                            <span class="badge bg-success">In Stock: {{ $product->quantity }} available</span>
                        @else
                            <span class="badge bg-secondary">Out of Stock</span>
                        @endif
                        <span class="badge bg-info ms-2">{{ $product->category }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Store:</strong> 
                        <a href="{{ route('shop.store', $product->store->id) }}" class="text-decoration-none">
                            {{ $product->store->name }}
                        </a>
                    </div>
                    
                    @if($product->quantity > 0)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantity</label>
                            <div class="quantity-selector d-flex align-items-center gap-2">
                                <button type="button" class="btn-quantity" id="btn-minus">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->quantity }}">
                                <button type="button" class="btn-quantity" id="btn-plus">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted">Maximum {{ $product->quantity }} items available</small>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <strong>Description:</strong>
                        <p class="text-muted mt-2">{{ $product->description }}</p>
                    </div>
                    
                    @if($product->quantity > 0)
                        <form id="addToCartForm" action="{{ route('shop.add-to-cart', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" id="formQuantity" value="1">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary-custom flex-grow-1">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                                <a href="{{ route('shop.products') }}" class="btn btn-outline-custom">
                                    Continue Shopping
                                </a>
                            </div>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">You May Also Like</h3>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $related->first_image }}" 
                             class="card-img-top" 
                             alt="{{ $related->name }}"
                             style="height: 150px; object-fit: cover;"
                             onerror="this.src='{{ asset('images/no-image.png') }}';">
                        @if(!$related->first_image || empty($related->images))
                            <div style="height: 150px; background: var(--gray-200); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image fa-2x" style="color: var(--gray-500);"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($related->name, 30) }}</h6>
                            <p class="text-oweru-gold fw-semibold">${{ number_format($related->price, 2) }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('shop.product', $related->id) }}" class="btn btn-outline-custom w-100">
                                View Product
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    .btn-primary-custom {
        background: var(--oweru-gold);
        border: none;
        color: var(--oweru-dark);
        padding: 12px 20px;
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
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-outline-custom:hover {
        border-color: var(--oweru-gold);
        color: var(--oweru-gold);
    }
    .quantity-selector {
        gap: 12px;
    }
    .btn-quantity {
        width: 36px;
        height: 36px;
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
        width: 70px;
        text-align: center;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 8px;
        font-size: 1rem;
    }
    .quantity-input:focus {
        outline: none;
        border-color: var(--oweru-gold);
    }
    .badge-success {
        background: #ECFDF5;
        color: #059669;
    }
    .badge-info {
        background: #EFF6FF;
        color: #2563EB;
    }
</style>
@endpush

@push('scripts')
<script>
    const quantityInput = document.getElementById('quantity');
    const formQuantity = document.getElementById('formQuantity');
    const btnMinus = document.getElementById('btn-minus');
    const btnPlus = document.getElementById('btn-plus');
    const maxStock = {{ $product->quantity }};
    
    function updateQuantity(value) {
        if (value >= 1 && value <= maxStock) {
            quantityInput.value = value;
            formQuantity.value = value;
        }
    }
    
    if (btnMinus) {
        btnMinus.addEventListener('click', () => {
            updateQuantity(parseInt(quantityInput.value) - 1);
        });
    }
    
    if (btnPlus) {
        btnPlus.addEventListener('click', () => {
            updateQuantity(parseInt(quantityInput.value) + 1);
        });
    }
    
    if (quantityInput) {
        quantityInput.addEventListener('change', () => {
            let value = parseInt(quantityInput.value);
            if (isNaN(value)) value = 1;
            if (value < 1) value = 1;
            if (value > maxStock) value = maxStock;
            updateQuantity(value);
        });
    }
</script>
@endpush
@endsection
