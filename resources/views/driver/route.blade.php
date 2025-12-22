<!DOCTYPE html>
<html>
<head>
    <title>Waste Collection - Driver Route</title>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <style>
        #map { height: 550px; width: 100%; border-radius: 10px; }
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .info { background: white; padding: 15px; border-radius: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="info">
        <h2>🚚 Driver Dispatch - Route #{{ $route->id }}</h2>
        <p><strong>Total Distance:</strong> {{ $route->total_distance }} KM</p>
    </div>

    <div id="map"></div>

    <script>
        function initMap() {
            // Controller JSON data JS array 
            const routePoints = @json($route->route_points);
            
            // Map center Colombo  (Starting point)
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: { lat: 6.9271, lng: 79.8612 }, 
            });

            // Route points Google format convert 
            const pathCoords = routePoints.map(point => ({ 
                lat: parseFloat(point.lat), 
                lng: parseFloat(point.lng) 
            }));

            // 1. Map markers (all pickup points )
            pathCoords.forEach((coord, index) => {
                new google.maps.Marker({
                    position: coord,
                    map: map,
                    label: (index + 1).toString(), // Order show
                    title: "Pickup Point " + (index + 1)
                });
            });

            // 2. Optimized Path  (Blue Line)
            const flightPath = new google.maps.Polyline({
                path: pathCoords,
                geodesic: true,
                strokeColor: "#2563eb",
                strokeOpacity: 1.0,
                strokeWeight: 5,
            });

            flightPath.setMap(map);
        }

        window.onload = initMap;
    </script>
</body>
</html>