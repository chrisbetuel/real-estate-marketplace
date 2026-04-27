@extends('layouts.app')

@section('title', 'Add Driver')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Delivery Driver</h4>
                </div>
                <form action="{{ route('store-owner.drivers.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Driver Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vehicle Type</label>
                            <select name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" required>
                                <option value="">Select vehicle</option>
                                <option value="bajaji">Bajaji</option>
                                <option value="three_wheel">Three Wheel</option>
                                <option value="car">Car</option>
                                <option value="motorcycle">Motorcycle</option>
                            </select>
                            @error('vehicle_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price per KM ($)</label>
                            <input type="number" step="0.01" name="price_per_km" class="form-control @error('price_per_km') is-invalid @enderror" required min="0">
                            @error('price_per_km') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Register Driver</button>
                        <a href="{{ route('store-owner.drivers') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

