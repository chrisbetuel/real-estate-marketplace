@extends('layouts.app')

@section('title', 'Drivers - Store Dashboard')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="fw-bold mb-2" style="color: var(--brand-dark);">Delivery Drivers</h1>
            <p class="text-muted">Manage your delivery drivers and see nearby available drivers</p>
        </div>
    </div>

    <!-- Create Driver Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('store-owner.drivers.create') }}" class="btn" style="background: var(--brand-gold); color: var(--brand-dark);">
                <i class="fas fa-plus me-2"></i>Add New Driver
            </a>
        </div>
    </div>

    <!-- Nearby Drivers Map Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-map-marked-alt me-2 text-primary"></i>Nearby Available Drivers</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="loadNearbyDrivers();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <p class="mb-0 text-muted small">Live map - updates every 30 seconds. Click markers for details.</p>
                </div>
                <div class="card-body p-0">
                    <div id="nearbyDriversMap" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Drivers List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Your Registered Drivers ({{ $drivers->total() }})</h5>
                    {{ $drivers->links() }}
                </div>
                <div class="card-body p-0">
                    @if($drivers->count() > 0)
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th>Price/km</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($drivers as $driver)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-light text-primary rounded-circle">
                                                            {{ substr($driver->user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $driver->user->name }}</div>
                                                        <small class="text-muted">{{ $driver->user->phone }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $driver->vehicle_type == 'car' ? 'primary' : 'success' }}">
                                                    {{ $driver->vehicle_label }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($driver->price_per_km, 2) }}</td>
                                            <td>
                                                @if($driver->current_lat && $driver->current_lng)
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        Online
                                                    </small>
                                                @else
                                                    <small class="text-muted">Offline</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $driver->is_online ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $driver->is_online ? 'Available' : 'Offline' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary toggle-driver" 
                                                        data-driver-id="{{ $driver->id }}"
                                                        data-available="{{ $driver->is_available }}">
                                                    {{ $driver->is_available ? 'Go Offline' : 'Go Online' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5>No drivers registered yet</h5>
                            <p class="text-muted">Add your first delivery driver to get started</p>
                            <a href="{{ route('store-owner.drivers.create') }}" class="btn btn-primary">
                                Add Driver
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFw0QBy4z5hq4DvvdWQKH_Vqx9Dmshp_V8&libraries=geometry&callback=initNearbyMap" async defer></script>
<script>
let nearbyMap;
let markers = [];

function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

function initNearbyMap() {
    const store = @json($store);
    nearbyMap = new google.maps.Map(document.getElementById('nearbyDriversMap'), {
        center: {lat: store.latitude || -6.792354, lng: store.longitude || 39.208169}, // Dar es Salaam fallback
        zoom: 12
    });

    // Load nearby drivers every 30s
    loadNearbyDrivers();
    setInterval(loadNearbyDrivers, 30000);
}

function loadNearbyDrivers() {
    clearMarkers();
    fetch('{{ route('store-owner.drivers.nearby') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
        },
        body: JSON.stringify({
            lat: @json($store->latitude || -6.792354),
            lng: @json($store->longitude || 39.208169),
            radius: 10
        })
    })
    .then(response => response.json())
    .then(drivers => {
        if (drivers.length === 0) {
            console.log('No nearby drivers');
            return;
        }
        const vehicleColors = {
            bajaji: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
            'three_wheel': 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png',
            car: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
            motorcycle: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
        };
        drivers.forEach(driver => {
            const position = {lat: parseFloat(driver.current_lat), lng: parseFloat(driver.current_lng)};
            const marker = new google.maps.Marker({
                position,
                map: nearbyMap,
                title: `${driver.user.name} (${driver.vehicle_label}) - $${driver.price_per_km}/km`,
                icon: vehicleColors[driver.vehicle_type] || 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
            });
            markers.push(marker);

            const infoContent = `
                <div style="min-width: 200px;">
                    <h6>${driver.user.name}</h6>
                    <p><strong>Vehicle:</strong> ${driver.vehicle_label}</p>
                    <p><strong>Rate:</strong> $${driver.price_per_km}/km</p>
                    <p><strong>Status:</strong> ${driver.is_online ? 'Online' : 'Offline'}</p>
                </div>
            `;
            const infoWindow = new google.maps.InfoWindow({content: infoContent});
            marker.addListener('click', () => infoWindow.open(nearbyMap, marker));
        });
    }).catch(error => {
        console.error('Error loading drivers:', error);
    });
}

// Toggle driver availability
document.querySelectorAll('.toggle-driver').forEach(btn => {
    btn.addEventListener('click', function() {
        const driverId = this.dataset.driverId;
        fetch(`/store-owner/drivers/${driverId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}
</style>
@endpush
@endsection

