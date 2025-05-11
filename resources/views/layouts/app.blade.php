<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Krishna Niswarth Seva Trust') }}</title>
    {{-- <title>{{ config('app.name', 'FarsanHub') }}</title> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fade.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>


<body class="ltr app sidebar-mini">

    <!-- <div id="global-loader">
        <img src="{{ asset('images/loader.svg') }}" class="loader-img" alt="Loader">
    </div> -->
    <div class="page is-expanded overflow-auto">
        <div class="page-main">
            <div class="app-content mt-0 overflow-auto">
                @include('admin.parts.sidebar')
                <div class="main-content">
                    <div class="side-app">
                        <div class="main-container container-fluid">
                            @include('admin.parts.header')
                            <hr class="dropdown-divider" />
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#top" id="back-to-top" style="display: none;"><i class="fa fa-long-arrow-up"></i></a>

    <script type="text/Javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script> <!-- jquery -->

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/spinner.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('sidemenu/sidemenu.js') }}"></script>
    <!-- <script src="{{ asset('assets/plugins/inputtags/inputtags.js') }}"></script> -->
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- datepicker -->
    <!-- <script src="{{ asset('assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script> -->

    <!--datetimepicker-->
    <!-- <script src="{{ asset('assets/adminlte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script> -->

    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        let map;
        let marker;

        function loadMap() {
            // Give time for modal to fully open before loading the map
            setTimeout(() => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;

                        // If map already exists, remove and recreate it
                        if (map) {
                            map.remove();
                        }

                        map = L.map('map').setView([lat, lon], 13);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);

                        marker = L.marker([lat, lon]).addTo(map)
                            .bindPopup("You are here!")
                            .openPopup();

                    }, function(error) {
                        alert("Error: " + error.message);
                    });
                } else {
                    alert("Geolocation is not supported by your browser.");
                }
            }, 500); // slight delay to ensure modal is rendered
        }

        function handleLanguageChange(selectElement) {
            const selectedLang = selectElement.value;
            // Redirect to the same page with the new language code in the URL
            window.location.href = 'lang/' + selectedLang;
        }
    </script>

</body>

</html>
