@extends('layouts.app')

@section('title', $product->name . ' - Real Estate Marketplace')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @forelse($product->images ?? ['https://via.placeholder.com/600x400'] as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ $image }}" class="d-block w-100" alt="{{ $product->name }}" style="height: 400px; object-fit: cover; border-radius: 10px;">
                    </div>
                    @empty
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/600x400" class="d-block w-100" alt="{{ $product->name }}" style="height: 400px; object-fit: cover; border-radius: 10px;">
                    </div>
                    @endforelse
                </div>
                @if(count($product->images ?? []) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-info">{{ ucfirst($product->type) }}</span>
                @if($product->is_available)
                    <span class="badge bg-success">Available</span>
                @else
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
            </div>

            <div class="mb-4">
                @if($product->price_sale)
                    <h3 class="text-primary">Sale Price: ${{ number_format($product->price_sale) }}</h3>
                @endif
                @if($product->price_rent)
                    <h4 class="text-success">Rent: ${{ number_format($product->price_rent) }}/{{ $product->rent_period }}</h4>
                @endif
            </div>

            <div class="mb-4">
                <h5>Description</h5>
                <p class="text-muted">{{ $product->description }}</p>
            </div>

            @if($product->specifications)
            <div class="mb-4">
                <h5>Specifications</h5>
                <table class="table table-sm">
                    @foreach($product->specifications as $key => $value)
                    <tr>
                        <th>{{ ucfirst($key) }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            <div class="mb-4">
                <h5>Store Information</h5>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->store->store_name }}</h6>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $product->store->store_address }}<br>
                            <i class="fas fa-phone me-2"></i>{{ $product->store->store_phone }}<br>
                            @if($product->store->store_email)
                                <i class="fas fa-envelope me-2"></i>{{ $product->store->store_email }}
                            @endif
                        </p>
                        <a href="{{ route('stores.show', $product->store) }}" class="btn btn-outline-primary btn-sm">
                            View Store
                        </a>
                    </div>
                </div>
            </div>

            @auth
                @if(Auth::user()->user_type == 'client')
                <div class="d-grid gap-2">
                    <a href="{{ route('messages.index') }}?product={{ $product->id }}" class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Contact Store
                    </a>
                    
                    <!-- Viewing Request Button -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewingRequestModal">
                        <i class="fas fa-calendar-check me-2"></i>Request Viewing
                    </button>
                </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Related Products</h3>
        </div>
        @foreach($relatedProducts as $related)
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <img src="{{ $related->images[0] ?? 'https://via.placeholder.com/300x200' }}" 
                     class="card-img-top" alt="{{ $related->name }}" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h6 class="card-title">{{ $related->name }}</h6>
                    @if($related->price_sale)
                        <p class="small text-primary">${{ number_format($related->price_sale) }}</p>
                    @endif
                    <a href="{{ route('products.show', $related) }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Viewing Request Modal -->
@auth
<div class="modal fade" id="viewingRequestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('products.viewing-request', $product) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Request Product Viewing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="preferred_date" class="form-label">Preferred Date</label>
                        <input type="date" class="form-control" id="preferred_date" name="preferred_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message to Store Owner</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Tell them when you'd like to view the product..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
@endsection