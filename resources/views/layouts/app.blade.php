<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#e63946">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>{{ config('app.name', 'FarsanHub') }}</title>
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

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-input.form-control { background-color: #fff !important; cursor: pointer; }
    </style>

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

    <!-- Flatpickr JS + global date picker init -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="date"]').forEach(function (el) {
                var config = {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd-m-Y',
                    allowInput: false,
                    disableMobile: true,
                };
                // If the input has data-fp-onchange, call that window function on date select
                if (el.dataset.fpOnchange) {
                    var fnName = el.dataset.fpOnchange;
                    config.onChange = function () {
                        if (typeof window[fnName] === 'function') window[fnName]();
                    };
                }
                flatpickr(el, config);
            });
        });
    </script>

    <style>
        /* ── NativePHP Mobile Tweaks ──────────────────────────────── */
        body {
            /* Prevent pull-to-refresh interfering with the WebView */
            overscroll-behavior-y: none;
            /* Respect device safe areas (notch / home indicator) */
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }
        /* Prevent accidental text selection on long-press */
        * { -webkit-user-select: none; user-select: none; }
        /* Re-enable text selection for inputs and text areas */
        input, textarea, [contenteditable] { -webkit-user-select: text; user-select: text; }
        /* Larger tap targets — WCAG minimum 44 × 44 px */
        .btn, .nav-link, .side-menu__item { min-height: 44px; }
        /* Prevent 300 ms click delay on touch devices */
        * { touch-action: manipulation; }
    </style>

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

    {{-- ── NativePHP Mobile: FCM device-token registration ─────────────── --}}
    <script>
    /**
     * NativePHP exposes window.NativePHP inside the Android WebView.
     * When available, we request the FCM token and POST it to our backend
     * so the server can send push notifications to this device.
     */
    (function registerFcmToken() {
        if (typeof window.NativePHP === 'undefined') return; // Not running in NativePHP

        window.NativePHP.requestPushToken(function (token) {
            if (!token) return;

            fetch('{{ route("admin.device.register-token") }}', {
                method: 'POST',
                headers: {
                    'Content-Type':  'application/json',
                    'Accept':        'application/json',
                    'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ token: token, platform: 'android' }),
            }).catch(function () { /* silent — non-critical */ });
        });
    })();

    /**
     * Opens the WhatsApp share sheet for an order report.
     * Called from the report index page with the selected filters.
     *
     * @param {string} monthYear  e.g. "2025-03"
     * @param {string|null} customerId
     */
    function shareReportOnWhatsApp(monthYear, customerId) {
        if (!monthYear) {
            alert('Please select a month first.');
            return;
        }

        const btn = document.getElementById('whatsapp-share-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Generating PDF...';
        }

        const params = new URLSearchParams({ month_year: monthYear });
        if (customerId) params.append('customer_id', customerId);

        fetch('{{ route("admin.order-report.share-whatsapp") }}?' + params.toString(), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (!data.success) {
                alert(data.message || 'Could not generate PDF. Please try again.');
                return;
            }

            // Try native WhatsApp app first; fall back to WhatsApp Web after 1.5 s
            window.location.href = data.whatsapp_url;
            setTimeout(function () {
                if (document.visibilityState !== 'hidden') {
                    window.open(data.whatsapp_web_url, '_blank');
                }
            }, 1500);
        })
        .catch(function () { alert('Network error. Please try again.'); })
        .finally(function () {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-whatsapp"></i> Share on WhatsApp';
            }
        });
    }
    </script>

</body>

</html>
