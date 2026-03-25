// resources/js/maps/search.js

class LocationSearch {
    constructor() {
        this.map = null;
        this.markers = [];
        this.infoWindow = null;
        this.searchRadius = 10; // miles
        this.userLocation = null;
    }

    initMap(elementId, center = { lat: 40.7128, lng: -74.0060 }) {
        this.map = new google.maps.Map(document.getElementById(elementId), {
            zoom: 12,
            center: center,
            styles: this.getMapStyles(),
            mapTypeControl: false,
            fullscreenControl: true,
            streetViewControl: false
        });

        this.infoWindow = new google.maps.InfoWindow();
        
        // Add user location marker
        this.addUserLocationMarker(center);
        
        return this.map;
    }

    getMapStyles() {
        return [
            {
                featureType: 'poi.business',
                stylers: [{ visibility: 'off' }]
            },
            {
                featureType: 'transit',
                elementType: 'labels.icon',
                stylers: [{ visibility: 'off' }]
            }
        ];
    }

    addUserLocationMarker(position) {
        return new google.maps.Marker({
            position: position,
            map: this.map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 8,
                fillColor: '#4285F4',
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 2,
            },
            title: 'Your location'
        });
    }

    addMarkers(locations, type = 'local') {
        locations.forEach(location => {
            const position = type === 'local' 
                ? { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) }
                : { lat: location.geometry.location.lat, lng: location.geometry.location.lng };

            const marker = new google.maps.Marker({
                position: position,
                map: this.map,
                title: location.name || location.title,
                icon: this.getMarkerIcon(type)
            });

            // Add click listener for info window
            marker.addListener('click', () => {
                this.showInfoWindow(marker, location, type);
            });

            this.markers.push(marker);
        });
    }

    getMarkerIcon(type) {
        const icons = {
            local: {
                url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
            },
            google: {
                url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
            },
            professional: {
                url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            },
            store: {
                url: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
            }
        };

        return icons[type] || icons.local;
    }

    showInfoWindow(marker, location, type) {
        let content = `
            <div class="p-3 max-w-xs">
                <h3 class="font-bold text-lg mb-2">${location.name || location.title}</h3>
        `;

        if (type === 'local') {
            content += `
                <p class="text-sm text-gray-600 mb-1">${location.address}</p>
                ${location.phone ? `<p class="text-sm text-gray-600 mb-1">📞 ${location.phone}</p>` : ''}
                ${location.distance ? `<p class="text-sm text-gray-600 mb-1">📍 ${location.distance.toFixed(1)} miles away</p>` : ''}
            `;
        } else {
            content += `
                <p class="text-sm text-gray-600 mb-1">${location.vicinity || 'Address not available'}</p>
                ${location.rating ? `
                    <p class="text-sm text-gray-600 mb-1">
                        ⭐ ${location.rating} (${location.user_ratings_total || 0} reviews)
                    </p>
                ` : ''}
            `;
        }

        content += `</div>`;

        this.infoWindow.setContent(content);
        this.infoWindow.open(this.map, marker);
    }

    clearMarkers() {
        this.markers.forEach(marker => marker.setMap(null));
        this.markers = [];
    }

    fitBounds() {
        if (this.markers.length === 0) return;

        const bounds = new google.maps.LatLngBounds();
        this.markers.forEach(marker => bounds.extend(marker.getPosition()));
        
        // Also include user location if available
        if (this.userLocation) {
            bounds.extend(this.userLocation);
        }

        this.map.fitBounds(bounds);
    }

    drawRadiusCircle(center, radius) {
        // Convert miles to meters
        const radiusInMeters = radius * 1609.34;
        
        return new google.maps.Circle({
            strokeColor: '#4285F4',
            strokeOpacity: 0.3,
            strokeWeight: 2,
            fillColor: '#4285F4',
            fillOpacity: 0.1,
            map: this.map,
            center: center,
            radius: radiusInMeters
        });
    }
}

// Export for use in other files
window.LocationSearch = LocationSearch;