 <!-- location model -->
 <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true"
 data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('portal.location') }}</h5>
            <a class="btn btn-primary ms-4" id="btn-location-save">
                <i class="fa fa-check"></i>
            </a>
            <a class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
        </div>
        <div class="modal-body">
            <div id="map-loader" class="text-center mb-2">
                <div class="spinner-border text-primary" role="status"></div>
                <p>Loading map...</p>
            </div>
            <div id="map" style="height: 400px; display: none;"></div>
        </div>
    </div>
</div>
</div>



 <!-- Leaflet CSS & JS -->
 <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

 <!-- jQuery -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

 <script>
    let map;
    let currentPosition = null; // Declare globally

    $(document).ready(function () {
        console.log('ready');

        $('#locationModal').on('shown.bs.modal', function () {
            const $loader = $('#map-loader');
            const $map = $('#map');
            const $latInput = $('#latitude');
            const $lonInput = $('#longitude');
            const $latCell = $('#lat-value');
            const $lonCell = $('#lon-value');

            const latVal = $latInput.val();
            const lonVal = $lonInput.val();

            console.log(latVal, lonVal);

            $loader.show();
            $map.hide();

            if (map) {
                map.remove();
            }

            function initMap(lat, lon, updateInputs = true) {
                map = L.map('map').setView([lat, lon], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                L.marker([lat, lon]).addTo(map).bindPopup("સ્થાન અહી છે").openPopup();

                map.whenReady(function () {
                    $loader.hide();
                    $map.show();
                    map.invalidateSize();

                    if (updateInputs) {
                        $latInput.val(lat.toFixed(6));
                        $lonInput.val(lon.toFixed(6));
                        $latCell.text(lat.toFixed(6));
                        $lonCell.text(lon.toFixed(6));
                    }
                });
            }

            if (latVal && lonVal) {
                initMap(parseFloat(latVal), parseFloat(lonVal), false);
            } else if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    currentPosition = position; // Save globally
                    initMap(position.coords.latitude, position.coords.longitude, true);
                }, function (error) {
                    $loader.html('<p class="text-danger">Unable to get location: ' + error.message + '</p>');
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                $loader.html('<p class="text-danger">Geolocation not supported.</p>');
            }
        });

        // ✅ Bind once
        $('#btn-location-save').on('click', function () {
            if (currentPosition) {
                $('#locationModal').modal('hide');
            } else {
                alert('Location not available yet.');
            }
        });

        $('#locationModal').on('hidden.bs.modal', function () {
            if (map) {
                map.remove();
                map = null;
            }
            currentPosition = null; // Reset
        });
    });
</script>