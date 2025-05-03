<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Krishna Niswarth Seva Trust')</title> <!-- Default title can be overridden -->

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WJRKNRWH');
    </script>
    <!-- End Google Tag Manager -->

    <meta name="description" content="ક્રિષ્ના નિ:સ્વાર્થ સેવા ટ્રસ્ટ એકલા રહેતાં અશક્ત વડીલોને ઘરે બેઠાં વિનામૂલ્યે ભોજન પહોંચાડતી સંસ્થા.">

    <!-- Keywords Tag (Gujarati and English) -->
    <meta name="keywords" content="ક્રિષ્ના નિસ્વાર્થ સેવા ટ્રસ્ટ, ક્રિષ્ના નિસ્વાર્થ સેવા ટ્રસ્ટ ચાંદલોડિયા, ક્રિષ્ના નિસ્વાર્થ સેવા ટ્રસ્ટ અમદાવાદ, ક્રિષ્ના સેવા ટ્રસ્ટ,ક્રિષ્ના સેવા ટ્રસ્ટ ચાંદલોડિયા, ક્રિષ્ના સેવા ટ્રસ્ટ અમદાવાદ, ક્રિષ્ના ટ્રસ્ટ, ક્રિષ્ના ટ્રસ્ટ ચાંદલોડિયા,ક્રિષ્ના ટ્રસ્ટ ગોતા, ક્રિષ્ના ટ્રસ્ટ અમદાવાદ,ચાંદલોડિયા, વિના મુલ્યે ટિફીન સેવા,Krishna Niswarth Seva Trust,Krishna Niswarth Seva Trust Chandlodiya, Krishna Niswarth Seva Trust Ahmedabad,Krishna Seva Trust,Krishna Seva Trust Chandlodiya,Krishna Seva Trust Ahmedabad,Krishna Trust,Krishna Trust Chandlodiya,Krishna Trust Ahmedabad,Chandlodiya, free food">

    <!-- Language Tag (English and Gujarati) -->
    <meta name="language" content="Gujarati, English">

    <!-- Open Graph Tags (Social Media Optimization) -->
    <meta property="og:title" content="Krishna Niswarth Seva Trust">
    <meta property="og:description" content="ક્રિષ્ના નિ:સ્વાર્થ સેવા ટ્રસ્ટ એકલા રહેતાં અશક્ત વડીલોને ઘરે બેઠાં વિનામૂલ્યે ભોજન પહોંચાડતી સંસ્થા.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="https://www.krishnaniswarthsevatrust.com/">
    <meta property="og:type" content="website">

    <!-- To avoid potential duplicate content issues.  -->
    <link rel="canonical" href="https://www.krishnaniswarthsevatrust.com/">

    <!-- Structured Data for Local Business in Gujarati and English -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Krishna Niswarth Seva Trust",
            "logo": "{{ asset('images/logo.png') }}",
            "telephone": "+919898445831",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "જૂની શિવમ ગેસ એજન્સીની સામે | Opp Old Shivam Gas Agency",
                "addressLocality": "ચાંદલોડિયા, અમદાવાદ, | Chandlodiya, Ahmedabad",
                "addressRegion": "ગુજરાત | Gujarat",
                "postalCode": "382481",
                "addressCountry": "IN"
            },
            "sameAs": [
                "https://chat.whatsapp.com/IKoFgfff0o64XjKEtutY4P",
                "https://www.facebook.com/people/Krishna-Niswarth-Seva-Trust/pfbid02JJW4F82dQP3szekEKW7R3cfHeGLG8jAK8USN19vivRu8dVQJUVwBmzfUZz6Y7FMyl/",
                "https://www.youtube.com/@krishnaniswarthsevatrust",
                "https://www.instagram.com/krishnaniswarth/?utm_source=qr&igsh=OGpwNnp5YWFqaHg0",
            ],
            "url": "https://www.krishnaniswarthsevatrust.com/"
        }
    </script>

    <!-- Structured Data for Reviews (In Gujarati and English) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Review",
            "itemReviewed": {
                "@type": "Product",
                "name": "Krishna Niswarth Seva Trust"
            },
            "reviewRating": {
                "@type": "Rating",
                "bestRating": "5",
                "ratingValue": "4.8",
                "worstRating": "1"
            },
            "author": {
                "@type": "Person",
                "name": "ચંદ્રકાંતભાઈ પટેલ | Chandrakantbhai Patel"
            }
        }
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- animate css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Hreflang Tags for Multilingual Content -->
    <link rel="alternate" href="https://www.krishnaniswarthsevatrust.com/" hreflang="en" />
    <link rel="alternate" href="https://www.krishnaniswarthsevatrust.com/gu" hreflang="gu" />
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WJRKNRWH"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Include the header -->
    @include('web.parts.header')

    <!-- Main content -->
    @yield('content') <!-- This is where page-specific content will be injected -->

    <!-- Include the footer -->
    @include('web.parts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

<script>
    document.getElementById('subscribeForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting normally
        console.log("Submitted");

        // Get the value from the phone number input
        const phone = document.getElementById('phone').value;

        // Validate the phone number (basic validation for length and numeric format)
        if (phone && phone.length >= 10 && !isNaN(phone)) {
            // Show success message
            document.getElementById('successMessage').style.display = 'block';

            // Optionally, you can hide the form after submission
            document.getElementById('subscribeForm').style.display = 'none';

            // Replace with your WhatsApp group link
            const whatsappGroupLink = "https://chat.whatsapp.com/IKoFgfff0o64XjKEtutY4P";

            // Create WhatsApp link with the phone number prefilled (if necessary)
            const whatsappLink = whatsappGroupLink.replace('phone_number', phone);

            // Open WhatsApp with the generated link after 2 seconds delay
            setTimeout(function() {
                window.open(whatsappLink, '_blank');
            }, 2000); // Delay for 2 seconds
        } else {
            alert("Please enter a valid phone number.");
        }
    });
</script>

</html>
