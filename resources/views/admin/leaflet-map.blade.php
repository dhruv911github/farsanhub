<!DOCTYPE html>
<html>
<head>
  <title>Krishna Niswarth Seva Trust</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Leaflet CSS & JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Leaflet Routing Machine CSS & JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

  <style>
    #map { height: 100vh; }
  </style>
</head>
<body>

<div id="map"></div>

<script>
  // HTTPS warning
  if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
    alert('Location accuracy may be limited over HTTP. Use HTTPS for better precision.');
  }

  const map = L.map('map').setView([0, 0], 13);

  // Add OpenStreetMap tiles
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Custom Icons
  const rickshawIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/5316/5316727.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50],
    popupAnchor: [0, -45]
  });

  const stopIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
    iconSize: [30, 30],
    iconAnchor: [15, 30],
    popupAnchor: [0, -30]
  });

  let userMarker, accuracyCircle;

  // Laravel-injected dynamic stop data
  const holdPoints = @json($locations);

  // Add stop markers to map
  holdPoints.forEach(point => {
    L.marker([point.lat, point.lng], { icon: stopIcon })
      .addTo(map)
      .bindPopup(point.label);
  });

  function showUserLocation(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    const accuracy = position.coords.accuracy;
    const userLocation = [lat, lng];

    console.log(`User location: ${lat}, ${lng}, Accuracy: ${accuracy}m`);

    // Center the map
    map.setView(userLocation, 15);

    // Add or update user marker
    if (!userMarker) {
      userMarker = L.marker(userLocation, { icon: rickshawIcon }).addTo(map).bindPopup("You are here").openPopup();
    } else {
      userMarker.setLatLng(userLocation);
    }

    // Add or update accuracy circle
    if (!accuracyCircle) {
      accuracyCircle = L.circle(userLocation, {
        radius: accuracy,
        color: 'blue',
        fillOpacity: 0.2
      }).addTo(map);
    } else {
      accuracyCircle.setLatLng(userLocation).setRadius(accuracy);
    }

    // Draw route (only once)
    if (!window.routeDrawn && holdPoints.length > 0) {
      const waypoints = [
        L.latLng(userLocation),
        ...holdPoints.map(stop => L.latLng(stop.lat, stop.lng))
      ];

      L.Routing.control({
        waypoints: waypoints,
        createMarker: () => null,
        addWaypoints: false,
        routeWhileDragging: false,
        show: false,
        lineOptions: {
          styles: [{ color: 'green', opacity: 0.8, weight: 5 }]
        }
      }).addTo(map);

      window.routeDrawn = true;
    }
  }

  // Initial location fetch
  navigator.geolocation.getCurrentPosition(showUserLocation, error => {
    alert("Location access denied or unavailable.");
    console.error("Geolocation error:", error);
  }, {
    enableHighAccuracy: true
  });

  // Continuous location tracking
  navigator.geolocation.watchPosition(showUserLocation, error => {
    console.error("Location update error:", error);
  }, {
    enableHighAccuracy: true,
    maximumAge: 0
  });
</script>

</body>
</html>
