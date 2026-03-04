<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FarsanHub | Farsan Shop')</title>

    <!-- SEO Meta (English + Gujarati) -->
    <meta name="description"
        content="FarsanHub - Farsan shop, Gujarat. Fresh Gujarati farsan, namkeen, sweets and snacks available. ફરસાણહબ - વડોદરામાં તાજું અને સ્વાદિષ્ટ ગુજરાતી ફરસાણ, નમકીન અને મીઠાઈ.">

    <meta name="keywords"
        content="FarsanHub Vadodara, Farsan Shop Vadodara, Farsan, Gujarati Farsan, Namkeen Shop Vadodara, Sweets Shop Vadodara, વડોદરા ફરસાણ દુકાન, વડોદરા નમકીન, વડોદરા મીઠાઈ, ફરસાણહબ વડોદરા">

    <meta name="language" content="English, Gujarati">

    <!-- Open Graph -->
    <meta property="og:title" content="FarsanHub | Fresh Gujarati Farsan">
    <meta property="og:description"
        content="Buy fresh farsan & namkeen. વડોદરામાં તાજું અને સ્વાદિષ્ટ ફરસાણ ઉપલબ્ધ.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="https://www.farsanhub.com/">
    <meta property="og:type" content="website">

    <!-- Canonical -->
    <link rel="canonical" href="https://www.farsanhub.com/">

    <!-- Structured Data - Local Business -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FoodEstablishment",
        "name": "FarsanHub",
        "image": "{{ asset('images/logo.png') }}",
        "telephone": "+919898445831",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Your Shop Address Here",
            "addressLocality": "Vadodara",
            "addressRegion": "Gujarat",
            "postalCode": "390001",
            "addressCountry": "IN"
        },
        "areaServed": "Vadodara",
        "servesCuisine": "Gujarati Farsan, Namkeen, Sweets",
        "priceRange": "₹",
        "url": "https://www.farsanhub.com/"
    }
    </script>

    <!-- Gujarati + English Review Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Review",
        "itemReviewed": {
            "@type": "LocalBusiness",
            "name": "FarsanHub"
        },
        "reviewRating": {
            "@type": "Rating",
            "ratingValue": "4.9",
            "bestRating": "5"
        },
        "author": {
            "@type": "Person",
            "name": "Happy Customer | સંતોષિત ગ્રાહક"
        }
    }
    </script>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
</head>

<body>

    @include('web.parts.header')

    @yield('content')

    @include('web.parts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

<script>
    document.getElementById('subscribeForm')?.addEventListener('submit', function(event) {
        event.preventDefault();

        const phone = document.getElementById('phone').value;

        if (phone && phone.length >= 10 && !isNaN(phone)) {

            document.getElementById('successMessage').style.display = 'block';
            document.getElementById('subscribeForm').style.display = 'none';

            const whatsappNumber = "919898445831";
            const message = encodeURIComponent("Hello FarsanHub Vadodara, I want to order farsan.");
            const whatsappLink = `https://wa.me/${whatsappNumber}?text=${message}`;

            setTimeout(function() {
                window.open(whatsappLink, '_blank');
            }, 1500);
        } else {
            alert("Please enter a valid phone number.");
        }
    });
</script>

</html>
