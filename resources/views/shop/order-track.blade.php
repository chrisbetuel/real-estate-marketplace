@extends('layouts.app')

@section('title', 'Track Order #' . $order->order_number . ' - Oweru')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('shop.my-orders') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me-1"></i> Back to Orders
                </a>
                <div>
                    <h1 class="h3 mb-1" style="color: var(--primary-dark);">Track Delivery #{{ $order->order_number }}</h1>
                    <p class="mb-0 text-muted">Real-time tracking for your order</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-12 mb-4">
            <!-- Map Container -->
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-0">
                    <div id="deliveryMap" style="height: 500px; width: 100%; border-radius: 12px;"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h6 class="mb-0 fw-semibold" style="color: var(--primary-dark);">Order Summary</h6>
                </div>
                <div class="card-body">
                    <div class="delivery-status mb-3">
                        <span class="badge bg-info fs-6 px-3 py-2">
                            {{ ucfirst(str_replace('_', ' ', $order->delivery_status ?? 'pending')) }}
                        </span>
                    </div>
                    <div class="driver-info mb-3 p-3 bg-light rounded">
                        <h6 class="mb-2">{{ $order->driver->vehicle_label ?? 'N/A' }} Driver</h6>
                        <p class="mb-1 small"><strong>{{ $order->driver->user->name ?? 'Driver' }}</strong></p>
                        <p class="mb-0 small text-muted">{{ $order->driver->price_per_km ? '$' . $order->driver->price_per_km . '/km' : '' }}</p>
                    </div>
                    <div class="route-info">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Store:</span>
                            <span>{{ $order->store->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Delivery:</span>
                            <span>{{ $order->shipping_address['address'] ?? 'TBD' }}, {{ $order->shipping_address['city'] ?? '' }}</span>
                        </div>
                        @if($order->delivery_eta)
                            <div class="alert alert-info">
                                <i class="fas fa-clock me-1"></i> ETA: {{ $order->delivery_eta->format('h:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
#deliveryMap {
    border-radius: 0 0 12px 12px;
}
.driver-info {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-lighter) 100%);
}
</style>
@endpush

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=geometry&callback=initDeliveryMap" async defer></script>
<script>
let deliveryMap, driverMarker, routePolyline, infoWindow;
const order = @json($order);

function initDeliveryMap() {
    const defaultCenter = {lat: -6.792354, lng: 39.208169}; // Dar es Salaam
    
    deliveryMap = new google.maps.Map(document.getElementById('deliveryMap'), {
        zoom: 13,
        center: order.driver?.current_lat && order.driver?.current_lng 
            ? {lat: parseFloat(order.driver.current_lat), lng: parseFloat(order.driver.current_lng)}
            : defaultCenter,
        mapTypeId: 'roadmap',
        styles: [
            {featureType: 'poi', elementType: 'labels', stylers: [{visibility: 'off'}]},
        ]
    });

    infoWindow = new google.maps.InfoWindow();

    // Add markers and route
    if (order.driver && order.driver.current_lat && order.driver.current_lng) {
        updateDriverMarker();
    }

    // Store marker
    if (order.store?.latitude && order.store?.longitude) {
        new google.maps.Marker({
            position: {lat: parseFloat(order.store.latitude), lng: parseFloat(order.store.longitude)},
            map: deliveryMap,
            title: order.store.name,
            icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
        });
    }

    // Delivery address marker (if coords available)
    if (order.shipping_address?.lat && order.shipping_address?.lng) {
        new google.maps.Marker({
            position: {lat: parseFloat(order.shipping_address.lat), lng: parseFloat(order.shipping_address.lng)},
            map: deliveryMap,
            title: 'Delivery Address',
            icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
        });
    }

    // Initial route draw
    drawDeliveryRoute();

    // Refresh every 15 seconds
    setInterval(() => {
        fetchDriverLocation();
        drawDeliveryRoute();
    }, 15000);
}

function updateDriverMarker() {
    const pos = {lat: parseFloat(order.driver.current_lat), lng: parseFloat(order.driver.current_lng)};
    const vehicleIcon = getVehicleIcon(order.driver.vehicle_type);

    if (driverMarker) {
        driverMarker.setPosition(pos);
    } else {
        driverMarker = new google.maps.Marker({
            position: pos,
            map: deliveryMap,
            title: `${order.driver.user.name} (${order.driver.vehicle_label})`,
            icon: vehicleIcon,
            animation: google.maps.Animation.DROP
        });

        driverMarker.addListener('click', () => {
            const content = `
                <div style="min-width: 200px;">
                    <strong>${order.driver.user.name}</strong><br>
                    <span>${order.driver.vehicle_label}</span><br>
                    ${order.driver.price_per_km ? '$' + order.driver.price_per_km + '/km' : ''}
                </div>
            `;
            infoWindow.setContent(content);
            infoWindow.open(deliveryMap, driverMarker);
        });
    }
}

function getVehicleIcon(vehicleType) {
    const icons = {
        'bajaji': 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
        'three_wheel': 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png',
        'car': 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        'motorcycle': 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
    };
    return icons[vehicleType] || 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
}

function drawDeliveryRoute() {
    if (!order.store?.latitude || !order.store?.longitude || !order.driver?.current_lat || !order.driver?.current_lng) {
        return;
    }

    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        map: deliveryMap,
        suppressMarkers: true,
        polylineOptions: {
            strokeColor: '#4285f4',
            strokeOpacity: 0.8,
            strokeWeight: 5
        }
    });

    const storePos = new google.maps.LatLng(order.store.latitude, order.store.longitude);
    const driverPos = new google.maps.LatLng(order.driver.current_lat, order.driver.current_lng);
    const deliveryPos = order.shipping_address?.lat && order.shipping_address?.lng 
        ? new google.maps.LatLng(order.shipping_address.lat, order.shipping_address.lng)
        : driverPos;

    directionsService.route({
        origin: storePos,
        destination: deliveryPos,
        waypoints: [{location: driverPos, stopover: false}],
        travelMode: google.maps.TravelMode.DRIVING,
        optimizeWaypoints: true
    }, (response, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(response);
            routePolyline = response.routes[0].overview_path;
        }
    });
}

function fetchDriverLocation() {
    fetch(`/api/drivers/${order.driver.id}/location`)
        .then(response => response.json())
        .then(data => {
            if (data.current_lat && data.current_lng) {
                order.driver.current_lat = data.current_lat;
                order.driver.current_lng = data.current_lng;
                updateDriverMarker();
                deliveryMap.panTo({lat: parseFloat(data.current_lat), lng: parseFloat(data.current_lng)});
            }
        })
        .catch(() => {
            // Fallback to initial position
            updateDriverMarker();
        });
}
</script>
@endpush
