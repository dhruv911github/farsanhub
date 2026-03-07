<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  {{-- Primary SEO --}}
  <title>Bhramani Khandavi House – Authentic Gujarati Farsan | Vadodara</title>
  <meta name="description" content="Bhramani Khandavi House – Best Khandavi, Samosa, Khaman, Dhokla & Gujarati Farsan in Shubhanpura, Vadodara. Wholesale & Retail orders available." />
  <meta name="keywords" content="Khandavi, Farsan, Gujarati Farsan, Samosa, Khaman, Dhokla, Patra, Vadodara, Baroda, Shubhanpura, wholesale farsan" />
  <meta name="author" content="Bhramani Khandavi House" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="{{ url('/home') }}" />

  {{-- CSRF meta (Laravel) --}}
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  {{-- Open Graph --}}
  <meta property="og:title" content="Bhramani Khandavi House – Authentic Gujarati Farsan" />
  <meta property="og:description" content="Fresh, hygienic & traditionally made Gujarati Farsan. Wholesale & Retail. Vadodara, Gujarat." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url('/home') }}" />
  <meta property="og:image" content="{{ asset('images/farsan/og-image.webp') }}" />
  <meta property="og:locale" content="en_IN" />

  {{-- Twitter Card --}}
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Bhramani Khandavi House" />
  <meta name="twitter:description" content="Authentic Gujarati Farsan – Khandavi, Samosa, Khaman & more. Vadodara." />

  {{-- Content Security Policy --}}
  <meta http-equiv="Content-Security-Policy" content="default-src 'self' https: data:; script-src 'self' https://cdn.jsdelivr.net https://unpkg.com 'unsafe-inline'; style-src 'self' https://cdn.jsdelivr.net https://fonts.googleapis.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net data:; img-src 'self' data: https: blob:; connect-src 'self' https:; frame-src https://www.google.com;" />

  {{-- Favicon --}}
  <link rel="icon" type="image/svg+xml" href="{{ asset('images/farsan-favicon.svg') }}" />

  {{-- Google Fonts: Poppins + Noto Sans Gujarati --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Noto+Sans+Gujarati:wght@400;500;600;700&display=swap" rel="stylesheet" />

  {{-- Bootstrap 5 CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  {{-- AOS Animate on Scroll --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('css/webpage.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

  {{-- JSON-LD Structured Data --}}
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "@id": "{{ url('/') }}",
    "name": "Bhramani Khandavi House",
    "alternateName": "બ્રાહ્માણી ખાંડવી હાઉસ",
    "description": "Authentic Gujarati Farsan shop specializing in Khandavi, Samosa, Khaman, Dhokla, Patra and more. Wholesale and retail orders available.",
    "url": "{{ url('/') }}",
    "telephone": "+91-XXXXXXXXXX",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Shubhanpura Area",
      "addressLocality": "Vadodara",
      "addressRegion": "Gujarat",
      "postalCode": "390023",
      "addressCountry": "IN"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": "22.3219",
      "longitude": "73.1906"
    },
    "openingHoursSpecification": [
      {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
        "opens": "07:00",
        "closes": "21:00"
      },
      {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": "Sunday",
        "opens": "07:00",
        "closes": "13:00"
      }
    ],
    "servesCuisine": "Gujarati",
    "priceRange": "₹"
  }
  </script>
</head>
<body>

{{-- ===================== NAVBAR ===================== --}}
<nav class="navbar navbar-expand-lg navbar-light sticky-top" id="mainNav" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#home">
      <div class="logo-icon" aria-hidden="true">
        <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="21" cy="21" r="21" fill="#FF9933"/>
          <text x="21" y="27" text-anchor="middle" font-size="20" font-family="serif" fill="white">ભ</text>
        </svg>
      </div>
      <div>
        <span class="brand-name" data-en="Bhramani Khandavi House" data-gu="બ્રાહ્માણી ખાંડવી હાઉસ">Bhramani Khandavi House</span>
        <small class="brand-sub d-block" data-en="Authentic Gujarati Farsan" data-gu="અસલી ગુજરાતી ફરસાણ">Authentic Gujarati Farsan</small>
      </div>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link" href="#home"       data-en="Home"       data-gu="હોમ">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about"      data-en="About Us"   data-gu="અમારા વિશે">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#products"   data-en="Products"   data-gu="ઉત્પાદનો">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="#wholesale"  data-en="Wholesale"  data-gu="જથ્થાબંધ">Wholesale</a></li>
        <li class="nav-item"><a class="nav-link" href="#gallery"    data-en="Gallery"    data-gu="ગેલેરી">Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="#testimonials" data-en="Reviews"  data-gu="સમીક્ષાઓ">Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact"    data-en="Contact"    data-gu="સંપર્ક">Contact</a></li>
        <li class="nav-item ms-lg-2 d-flex gap-2 align-items-center">
          <button class="btn btn-lang d-flex align-items-center" id="langToggle" aria-label="Switch language">
            <i class="bi bi-translate me-1"></i>
            <span id="langLabel">ગુજરાતી</span>
          </button>
          <a href="{{ route('login') }}" class="btn btn-admin d-flex align-items-center" aria-label="Admin Login">
            <i class="bi bi-shield-lock me-1"></i>Admin
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

{{-- ===================== HERO ===================== --}}
<section id="home" class="hero-section" aria-label="Hero banner">
  <div class="hero-overlay"></div>
  <div class="hero-bg-pattern" aria-hidden="true"></div>
  <div class="container hero-content">
    <div class="row align-items-center min-vh-hero">
      <div class="col-12 col-lg-6 hero-text-col" data-aos="fade-right" data-aos-duration="900">
        <span class="hero-badge" data-en="🌟 Vadodara's Favourite" data-gu="🌟 વડોદરાની પ્રિય">🌟 Vadodara's Favourite</span>
        <h1 class="hero-title">
          <span data-en="Authentic Gujarati" data-gu="અસલી ગુજરાતી સ્વાદ">Authentic Gujarati</span><br>
          <span class="text-highlight" data-en="Taste Since Years" data-gu="સ્વાદ સૈ વર્ષ">Taste Since Years</span>
        </h1>
        <p class="hero-subtitle" data-en="From our kitchen to your heart — freshly made Khandavi, Samosa, Khaman, Dhokla &amp; more. Pure taste, pure love." data-gu="અમારી રસોઈથી તમારા હૃદય સુધી — તાજી ખાંડવી, સામોસા, ખમણ, ઢોકળા અને વધુ. શુદ્ધ સ્વાદ, શુદ્ધ પ્રેમ.">
          From our kitchen to your heart — freshly made Khandavi, Samosa, Khaman, Dhokla &amp; more. Pure taste, pure love.
        </p>
        <div class="hero-cta d-flex flex-wrap gap-3">
          <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20place%20an%20order" class="btn btn-primary-custom btn-lg" target="_blank" rel="noopener noreferrer" data-en="Order on WhatsApp" data-gu="WhatsApp પર ઓર્ડર કરો">
            <i class="bi bi-whatsapp me-2"></i>Order on WhatsApp
          </a>
          <a href="#products" class="btn btn-outline-custom btn-lg" data-en="View Products" data-gu="ઉત્પાદનો જુઓ">
            <i class="bi bi-grid me-2"></i>View Products
          </a>
        </div>
        <div class="hero-stats d-flex gap-4 mt-4">
          <div class="stat-item">
            <span class="stat-number">500+</span>
            <span class="stat-label" data-en="Happy Customers" data-gu="ખુશ ગ્રાહકો">Happy Customers</span>
          </div>
          <div class="stat-divider" aria-hidden="true"></div>
          <div class="stat-item">
            <span class="stat-number">10+</span>
            <span class="stat-label" data-en="Years of Taste" data-gu="સ્વાદના વર્ષ">Years of Taste</span>
          </div>
          <div class="stat-divider" aria-hidden="true"></div>
          <div class="stat-item">
            <span class="stat-number">15+</span>
            <span class="stat-label" data-en="Farsan Items" data-gu="ફરસાણ આઇટમ">Farsan Items</span>
          </div>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-flex justify-content-end" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
        <div class="hero-image-wrap">
          <div class="hero-dish hero-dish-1">
            <img src="{{ asset('images/farsan/khandavi.jpg') }}" alt="Fresh Khandavi" loading="eager" width="200" height="200"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22%23FF993322%22 width=%22200%22 height=%22200%22 rx=%22100%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2240%22>🥗</text></svg>'" />
            <span class="dish-label" data-en="Khandavi" data-gu="ખાંડવી">Khandavi</span>
          </div>
          <div class="hero-dish hero-dish-2">
            <img src="{{ asset('images/farsan/samosa.jpg') }}" alt="Crispy Samosa" loading="eager" width="160" height="160"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22160%22 height=%22160%22><rect fill=%22%23FFC10722%22 width=%22160%22 height=%22160%22 rx=%2280%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2240%22>🥟</text></svg>'" />
            <span class="dish-label" data-en="Samosa" data-gu="સામોસા">Samosa</span>
          </div>
          <div class="hero-dish hero-dish-3">
            <img src="{{ asset('images/farsan/khaman.jpg') }}" alt="Soft Khaman" loading="eager" width="140" height="140"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22140%22 height=%22140%22><rect fill=%22%23FF993322%22 width=%22140%22 height=%22140%22 rx=%2270%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2236%22>🍰</text></svg>'" />
            <span class="dish-label" data-en="Khaman" data-gu="ખમણ">Khaman</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a href="#about" class="scroll-down-btn" aria-label="Scroll to About">
    <i class="bi bi-chevron-double-down"></i>
  </a>
</section>

{{-- ===================== ABOUT ===================== --}}
<section id="about" class="section-pad bg-white" aria-labelledby="about-heading">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="about-image-grid">
          <div class="about-img-main">
            <img src="{{ asset('images/farsan/shop-front.webp') }}" alt="Bhramani Khandavi House shop front" loading="lazy" class="rounded-4 w-100"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22><rect fill=%22%23FF993311%22 width=%22400%22 height=%22300%22/><text x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 font-size=%2260%22>🏪</text></svg>'" />
          </div>
          <div class="about-img-badge">
            <i class="bi bi-award-fill"></i>
            <span data-en="Since Years" data-gu="વર્ષોથી">Since Years</span>
          </div>
        </div>
      </div>
      <div class="col-lg-7" data-aos="fade-left" data-aos-delay="150">
        <div class="section-label" data-en="Our Story" data-gu="અમારી વાર્તા">Our Story</div>
        <h2 class="section-title" id="about-heading">
          <span data-en="A Legacy of" data-gu="નો વારસો">A Legacy of</span>
          <span class="text-saffron" data-en=" Authentic Taste" data-gu=" અસ્સલ સ્વાદ"> Authentic Taste</span>
        </h2>
        <p class="section-text" data-en="Bhramani Khandavi House has been serving the people of Vadodara with the most authentic and flavorful Gujarati Farsan for years. Nestled in the heart of Shubhanpura, our shop is a beloved destination for food lovers who crave the real taste of Gujarat." data-gu="બ્રાહ્માણી ખાંડવી હાઉસ વર્ષોથી વડોદરાના લોકોને સૌથી અસ્સલ અને સ્વાદિષ્ટ ગુજરાતી ફરસાણ પ્રદાન કરતી આવ્યું છે. શુભાનપુરાના હ્રદયમાં વસેલ, અમારી દુકાન ગુજરાતના સાચા સ્વાદ માટે ભૂખ્યા ખોરાક-પ્રેમીઓ માટે એક પ્રિય સ્થળ છે.">
          Bhramani Khandavi House has been serving the people of Vadodara with the most authentic and flavorful Gujarati Farsan for years. Nestled in the heart of Shubhanpura, our shop is a beloved destination for food lovers who crave the real taste of Gujarat.
        </p>
        <div class="row g-3 mt-2">
          <div class="col-sm-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="about-feature-card">
              <div class="feature-icon"><i class="bi bi-flower1"></i></div>
              <h4 data-en="Fresh Ingredients" data-gu="તાજા સામગ્રી">Fresh Ingredients</h4>
              <p data-en="Sourced fresh daily for maximum flavour and nutrition." data-gu="મહત્તમ સ્વાદ અને પોષણ માટે દરરોજ તાજી સામગ્રી.">Sourced fresh daily for maximum flavour and nutrition.</p>
            </div>
          </div>
          <div class="col-sm-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="about-feature-card">
              <div class="feature-icon"><i class="bi bi-heart-fill"></i></div>
              <h4 data-en="Traditional Recipe" data-gu="પરંપરાગત રેસિપી">Traditional Recipe</h4>
              <p data-en="Generations-old recipes passed down with love." data-gu="પ્રેમ સાથે વારસામાં મળેલ પેઢી-જૂની રેસિપી.">Generations-old recipes passed down with love.</p>
            </div>
          </div>
          <div class="col-sm-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="about-feature-card">
              <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
              <h4 data-en="Hygiene First" data-gu="સ્વચ્છતા પ્રથમ">Hygiene First</h4>
              <p data-en="Prepared in a clean, hygienic kitchen with care." data-gu="સ્વચ્છ, સ્વચ્છ રસોઈઘરમાં કાળજી સાથે તૈયાર.">Prepared in a clean, hygienic kitchen with care.</p>
            </div>
          </div>
          <div class="col-sm-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="about-feature-card">
              <div class="feature-icon"><i class="bi bi-box-seam"></i></div>
              <h4 data-en="Bulk Orders Welcome" data-gu="જથ્થાબંધ ઓર્ડર સ્વીકાર્ય">Bulk Orders Welcome</h4>
              <p data-en="Catering for weddings, events &amp; functions." data-gu="લગ્ન, ઇવેન્ટ અને કાર્યક્રમો માટે કેટરિંગ.">Catering for weddings, events &amp; functions.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===================== PRODUCTS ===================== --}}
<section id="products" class="section-pad bg-light-saffron" aria-labelledby="products-heading">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label" data-en="Our Menu" data-gu="અમારું મેનૂ">Our Menu</div>
      <h2 class="section-title" id="products-heading">
        <span data-en="Freshly Made " data-gu="તાજી બનાવેલ ">Freshly Made </span>
        <span class="text-saffron" data-en="Farsan" data-gu="ફરસાણ">Farsan</span>
      </h2>
      <p class="section-subtitle" data-en="Each item is crafted with authentic Gujarati recipes, fresh ingredients, and lots of love." data-gu="દરેક આઇટમ અસલી ગુજરાતી રેસિપી, તાજી સામગ્રી અને ઘણો પ્રેમ સાથે તૈયાર.">
        Each item is crafted with authentic Gujarati recipes, fresh ingredients, and lots of love.
      </p>
    </div>
    <div class="row g-4">

      {{-- Khandavi - Featured --}}
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="product-card featured-product">
          <div class="product-badge" data-en="⭐ Special" data-gu="⭐ વિશેષ">⭐ Special</div>
          <div class="product-img-wrap">
            <img src="{{ asset('images/farsan/khandavi.jpg') }}" alt="Khandavi" loading="lazy" width="380" height="240"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22380%22 height=%22240%22><rect fill=%22%23FF993322%22 width=%22380%22 height=%22240%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2270%22>🥗</text></svg>'" />
          </div>
          <div class="product-body">
            <h3 class="product-name" data-en="Khandavi" data-gu="ખાંડવી">Khandavi</h3>
            <p class="product-desc" data-en="Our signature dish — silky smooth, spiced besan rolls garnished with fresh coconut and mustard seeds. The taste you can't forget!" data-gu="અમારી સિગ્નેચર ડિશ — રેશમ જેવી, મસાલેદાર બેસન રોલ, તાજા નાળિયેર અને રાઈ સાથે. ભૂલી ન શકાય એવો સ્વાદ!">
              Our signature dish — silky smooth, spiced besan rolls garnished with fresh coconut and mustard seeds.
            </p>
            <div class="product-footer">
              <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Khandavi" class="btn btn-product" target="_blank" rel="noopener noreferrer" data-en="Order Now" data-gu="હવે ઓર્ડર કરો">
                <i class="bi bi-whatsapp me-1"></i>Order Now
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Samosa - Featured --}}
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="product-card featured-product">
          <div class="product-badge" data-en="🔥 Popular" data-gu="🔥 લોકપ્રિય">🔥 Popular</div>
          <div class="product-img-wrap">
            <img src="{{ asset('images/farsan/samosa.jpg') }}" alt="Crispy Samosa" loading="lazy" width="380" height="240"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22380%22 height=%22240%22><rect fill=%22%23FFC10722%22 width=%22380%22 height=%22240%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2270%22>🥟</text></svg>'" />
          </div>
          <div class="product-body">
            <h3 class="product-name" data-en="Samosa" data-gu="સામોસા">Samosa</h3>
            <p class="product-desc" data-en="Crispy golden crust filled with perfectly spiced potato-pea stuffing. Best served hot with green chutney!" data-gu="સ્પષ્ટ સોનેરી ક્રસ્ટ, સ્પષ્ટ મસાલેદાર બટેટા-વટાણા ભરણ સાથે. ગ્રીન ચટણી સાથે ગરમ!">
              Crispy golden crust filled with perfectly spiced potato-pea stuffing. Best served hot!
            </p>
            <div class="product-footer">
              <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Samosa" class="btn btn-product" target="_blank" rel="noopener noreferrer" data-en="Order Now" data-gu="હવે ઓર્ડર કરો">
                <i class="bi bi-whatsapp me-1"></i>Order Now
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Khaman --}}
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="{{ asset('images/farsan/khaman.jpg') }}" alt="Soft Khaman" loading="lazy" width="380" height="240"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22380%22 height=%22240%22><rect fill=%22%23FF993311%22 width=%22380%22 height=%22240%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2270%22>🍰</text></svg>'" />
          </div>
          <div class="product-body">
            <h3 class="product-name" data-en="Khaman" data-gu="ખમણ">Khaman</h3>
            <p class="product-desc" data-en="Soft, spongy & tangy steamed chickpea cake. Light on stomach, heavy on taste!" data-gu="નરમ, સ્પોન્જી અને ટેન્ગી. પેટ પર હળવો, સ્વાદ પર ભારે!">
              Soft, spongy &amp; tangy steamed chickpea cake. Light on stomach, heavy on taste!
            </p>
            <div class="product-footer">
              <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Khaman" class="btn btn-product" target="_blank" rel="noopener noreferrer" data-en="Order Now" data-gu="હવે ઓર્ડર કરો">
                <i class="bi bi-whatsapp me-1"></i>Order Now
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Patra --}}
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="{{ asset('images/farsan/patra.jpg') }}" alt="Patra" loading="lazy" width="380" height="240"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22380%22 height=%22240%22><rect fill=%22%235C3A2222%22 width=%22380%22 height=%22240%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2270%22>🌿</text></svg>'" />
          </div>
          <div class="product-body">
            <h3 class="product-name" data-en="Patra" data-gu="પાત્રા">Patra</h3>
            <p class="product-desc" data-en="Colocasia leaves rolled with spiced besan paste and steamed to perfection. A unique Gujarati delicacy!" data-gu="અળવીના પાન, મસાલેદાર બેસન સાથે. અનોખી ગુજરાતી ડેલિકેટ!">
              Colocasia leaves rolled with spiced besan paste and steamed to perfection.
            </p>
            <div class="product-footer">
              <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Patra" class="btn btn-product" target="_blank" rel="noopener noreferrer" data-en="Order Now" data-gu="હવે ઓર્ડર કરો">
                <i class="bi bi-whatsapp me-1"></i>Order Now
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Dhokla --}}
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="{{ asset('images/farsan/dhokla.jpg') }}" alt="Steamed Dhokla" loading="lazy" width="380" height="240"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22380%22 height=%22240%22><rect fill=%22%23FFC10722%22 width=%22380%22 height=%22240%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2270%22>🟡</text></svg>'" />
          </div>
          <div class="product-body">
            <h3 class="product-name" data-en="Dhokla" data-gu="ઢોકળા">Dhokla</h3>
            <p class="product-desc" data-en="Fluffy steamed rice-chickpea cake with tangy-sweet tempering. Healthy and delicious!" data-gu="ફ્લ્uffી સ્ટીમ્ડ ચોખા-ચણા કેક. સ્વસ્થ અને સ્વાદિષ્ટ!">
              Fluffy steamed rice-chickpea cake with tangy-sweet tempering. Healthy and delicious!
            </p>
            <div class="product-footer">
              <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Dhokla" class="btn btn-product" target="_blank" rel="noopener noreferrer" data-en="Order Now" data-gu="હવે ઓર્ડર કરો">
                <i class="bi bi-whatsapp me-1"></i>Order Now
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Mix Farsan --}}
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="{{ asset('images/farsan/mix-farsan.jpg') }}" alt="Mix Farsan" loading="lazy" width="380" height="240"
              onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22380%22 height=%22240%22><rect fill=%22%23FF993311%22 width=%22380%22 height=%22240%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2270%22>🍽️</text></svg>'" />
          </div>
          <div class="product-body">
            <h3 class="product-name" data-en="Mix Farsan" data-gu="મિક્સ ફરસાણ">Mix Farsan</h3>
            <p class="product-desc" data-en="A festive assortment of our best Farsan — perfect for parties, gifts &amp; daily snacking!" data-gu="ઉત્સવ ફરસાણ સેટ — પાર્ટી, ભેટ અને નાસ્તા માટે!">
              A festive assortment of our best Farsan — perfect for parties, gifts &amp; daily snacking!
            </p>
            <div class="product-footer">
              <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Mix%20Farsan" class="btn btn-product" target="_blank" rel="noopener noreferrer" data-en="Order Now" data-gu="હવે ઓર્ડર કરો">
                <i class="bi bi-whatsapp me-1"></i>Order Now
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ===================== WHOLESALE ===================== --}}
<section id="wholesale" class="section-pad wholesale-section" aria-labelledby="wholesale-heading">
  <div class="wholesale-overlay" aria-hidden="true"></div>
  <div class="container position-relative">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8" data-aos="zoom-in">
        <div class="section-label light" data-en="For Events &amp; Functions" data-gu="ઇવેન્ટ્સ અને ફંક્શન માટે">For Events &amp; Functions</div>
        <h2 class="section-title text-white" id="wholesale-heading">
          <span data-en="Wholesale &amp; Bulk " data-gu="જથ્થાબંધ &amp; મોટા ">Wholesale &amp; Bulk </span>
          <span class="text-yellow" data-en="Orders" data-gu="ઓર્ડર">Orders</span>
        </h2>
        <p class="text-white-75 fs-5 mb-4" data-en="Planning a wedding, engagement, birthday party, or corporate event? We supply bulk Farsan orders with fresh preparation, timely delivery and best prices in Vadodara." data-gu="લગ્ન, સગાઈ, જન્મ-દિવસ અથવા ઇવેન્ટ? ફ્રેશ, સમયસર અને સૌથી સારા ભાવ સાથે જથ્થાબંધ ઓર્ડર.">
          Planning a wedding, engagement, birthday party, or corporate event? We supply bulk Farsan orders with fresh preparation, timely delivery and best prices in Vadodara.
        </p>
        <div class="wholesale-features d-flex flex-wrap justify-content-center gap-3 mb-5">
          <div class="ws-feature" data-en="🎊 Weddings" data-gu="🎊 લગ્ન">🎊 Weddings</div>
          <div class="ws-feature" data-en="🎂 Birthday Parties" data-gu="🎂 જન્મ-દિવસ">🎂 Birthday Parties</div>
          <div class="ws-feature" data-en="🏢 Corporate Events" data-gu="🏢 કોર્પોરેટ ઇવેન્ટ">🏢 Corporate Events</div>
          <div class="ws-feature" data-en="🙏 Religious Functions" data-gu="🙏 ધાર્મિક કાર્યક્રમ">🙏 Religious Functions</div>
          <div class="ws-feature" data-en="🎉 Engagement" data-gu="🎉 સગાઈ">🎉 Engagement</div>
        </div>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
          <a href="https://wa.me/919574659456?text=Hello%2C%20I%20need%20bulk%20order%20inquiry" class="btn btn-yellow btn-lg" target="_blank" rel="noopener noreferrer" data-en="Get Bulk Quote on WhatsApp" data-gu="WhatsApp પર ભાવ મેળવો">
            <i class="bi bi-whatsapp me-2"></i>Get Bulk Quote on WhatsApp
          </a>
          <a href="#contact" class="btn btn-outline-white btn-lg" data-en="Send Inquiry" data-gu="ઇન્ક્વાયરી મોકલો">
            <i class="bi bi-envelope me-2"></i>Send Inquiry
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===================== GALLERY ===================== --}}
<section id="gallery" class="section-pad bg-white" aria-labelledby="gallery-heading">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label" data-en="Visual Feast" data-gu="દ્રશ્ય તહેવાર">Visual Feast</div>
      <h2 class="section-title" id="gallery-heading">
        <span data-en="Our " data-gu="અમારી ">Our </span>
        <span class="text-saffron" data-en="Gallery" data-gu="ગેલેરી">Gallery</span>
      </h2>
    </div>
    <div class="gallery-grid" role="list" aria-label="Food gallery">
      @php
        $galleryItems = [
          ['file' => 'khandavi.jpg',  'emoji' => '🥗',  'en' => 'Khandavi',  'gu' => 'ખાંડવી',  'large' => true],
          ['file' => 'samosa.jpg',    'emoji' => '🥟',  'en' => 'Samosa',    'gu' => 'સામોસા',   'large' => false],
          ['file' => 'khaman.jpg',    'emoji' => '🍰',  'en' => 'Khaman',    'gu' => 'ખમણ',     'large' => false],
          ['file' => 'dhokla.jpg',    'emoji' => '🟡',  'en' => 'Dhokla',    'gu' => 'ઢોકળા',   'large' => false],
          ['file' => 'patra.jpg',     'emoji' => '🌿',  'en' => 'Patra',     'gu' => 'પાત્રા',   'large' => false],
          ['file' => 'shop-front.webp','emoji' => '🏪',  'en' => 'Our Shop',  'gu' => 'અમારી દુકાન','large' => true],
        ];
      @endphp
      @foreach($galleryItems as $i => $item)
      <div class="gallery-item {{ $item['large'] ? 'gallery-item-large' : '' }}" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}" role="listitem">
        <img src="{{ asset('images/farsan/' . $item['file']) }}" alt="{{ $item['en'] }}" loading="lazy"
          onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22><rect fill=%22%23FF993311%22 width=%22400%22 height=%22300%22/><text x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22 font-size=%2280%22>{{ $item['emoji'] }}</text></svg>'" />
        <div class="gallery-overlay">
          <span class="gallery-caption" data-en="{{ $item['en'] }}" data-gu="{{ $item['gu'] }}">{{ $item['en'] }}</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===================== TESTIMONIALS ===================== --}}
<section id="testimonials" class="section-pad bg-light-saffron" aria-labelledby="testimonials-heading">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label" data-en="What Customers Say" data-gu="ગ્રાહકો શું કહે છે">What Customers Say</div>
      <h2 class="section-title" id="testimonials-heading">
        <span data-en="Happy " data-gu="ખુશ ">Happy </span>
        <span class="text-saffron" data-en="Customers" data-gu="ગ્રાહકો">Customers</span>
      </h2>
    </div>
    <div class="row g-4">

      @php
        $testimonials = [
          ['initial'=>'P','name_en'=>'Priya Shah','name_gu'=>'પ્રિયા શાહ','loc_en'=>'Regular Customer, Shubhanpura','loc_gu'=>'નિયમિત ગ્રાહક, શુભાનપુરા','stars'=>5,
           'text_en'=>'"The Khandavi from Bhramani is simply the best in Vadodara! The texture is perfect and the taste is just like home-made. We order every week!"',
           'text_gu'=>'"બ્રાહ્માણીની ખાંડવી વડોદરામાં સૌ કરતા ઉત્તમ! ટેક્સ્ચર પરફેક્ટ અને સ્વાદ ઘરની જેવો. અઠવાડિયે ઓર્ડર!"'],
          ['initial'=>'R','name_en'=>'Rameshbhai Patel','name_gu'=>'રમેશભાઈ પટેલ','loc_en'=>'Wedding Client, Vadodara','loc_gu'=>'લગ્ન ક્લાઇન્ટ, વડોદરા','stars'=>5,
           'text_en'=>'"We ordered 50 kg Farsan for our daughter\'s wedding. Everything was fresh, delivered on time and the guests couldn\'t stop praising!"',
           'text_gu'=>'"50 કિલો ફરસાણ ઓર્ડર. તાજું, સમયસર ડિલિવરી. ભારે ભલામણ!"'],
          ['initial'=>'M','name_en'=>'Meena Desai','name_gu'=>'મીના દેસાઈ','loc_en'=>'Daily Customer, Vadodara','loc_gu'=>'દૈનિક ગ્રાહક, વડોદરા','stars'=>5,
           'text_en'=>'"The Samosa here is unmatched! Crispy outside, perfectly spiced inside. Pure Gujarati joy!"',
           'text_gu'=>'"સામોસા અજોડ! ક્રિસ્પી બહાર, અંદર પરફેક્ટ. ગુજરાતી આનંદ!"'],
          ['initial'=>'K','name_en'=>'Kavita Joshi','name_gu'=>'કવિતા જોષી','loc_en'=>'Regular Customer, Vadodara','loc_gu'=>'નિયમિત ગ્રાહક, વડોદરા','stars'=>5,
           'text_en'=>'"Patra and Dhokla are always fresh and hygienically prepared. A true gem in Shubhanpura!"',
           'text_gu'=>'"પાત્રા અને ઢોકળા હંમેશા તાજા. શુભાનપુરામાં ઝવેરાત!"'],
          ['initial'=>'A','name_en'=>'Amit Mehta','name_gu'=>'અમિત મહેતા','loc_en'=>'Customer, Vadodara','loc_gu'=>'ગ્રાહક, વડોદરા','stars'=>4,
           'text_en'=>'"Great quality farsan at reasonable prices. Mix Farsan pack is perfect for gifting!"',
           'text_gu'=>'"ઉત્કૃષ્ટ ફરસાણ. મિક્સ ફરસાણ ભેટ માટે ઉત્તમ!"'],
        ];
      @endphp

      @foreach($testimonials as $i => $t)
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
        <div class="testimonial-card">
          <div class="stars" aria-label="{{ $t['stars'] }} out of 5 stars">
            @for($s=1;$s<=5;$s++){{ $s <= $t['stars'] ? '★' : '☆' }}@endfor
          </div>
          <p class="testimonial-text" data-en="{{ $t['text_en'] }}" data-gu="{{ $t['text_gu'] }}">{{ $t['text_en'] }}</p>
          <div class="testimonial-author">
            <div class="author-avatar" aria-hidden="true">{{ $t['initial'] }}</div>
            <div>
              <strong data-en="{{ $t['name_en'] }}" data-gu="{{ $t['name_gu'] }}">{{ $t['name_en'] }}</strong>
              <small data-en="{{ $t['loc_en'] }}" data-gu="{{ $t['loc_gu'] }}">{{ $t['loc_en'] }}</small>
            </div>
          </div>
        </div>
      </div>
      @endforeach

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="testimonial-card highlight-card">
          <div class="quote-icon" aria-hidden="true"><i class="bi bi-quote"></i></div>
          <p class="testimonial-highlight-text" data-en="&quot;The authentic taste of Gujarat in every bite!&quot;" data-gu="&quot;દરેક ટુકડામાં ગુજરાતનો અસ્સલ સ્વાદ!&quot;">
            "The authentic taste of Gujarat in every bite!"
          </p>
          <div class="mt-3 text-center">
            <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20share%20feedback" class="btn btn-product-sm" target="_blank" rel="noopener noreferrer" data-en="Share Your Review" data-gu="સમીક્ષા શેર કરો">
              <i class="bi bi-whatsapp me-1"></i>Share Your Review
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ===================== CONTACT ===================== --}}
<section id="contact" class="section-pad bg-white" aria-labelledby="contact-heading">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label" data-en="Find Us" data-gu="અમને શોધો">Find Us</div>
      <h2 class="section-title" id="contact-heading">
        <span data-en="Get In " data-gu="સંપર્ક ">Get In </span>
        <span class="text-saffron" data-en="Touch" data-gu="કરો">Touch</span>
      </h2>
    </div>
    <div class="row g-5">

      <div class="col-lg-5" data-aos="fade-right">
        <div class="contact-info-card mb-4">
          <div class="contact-info-item">
            <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
            <div>
              <strong data-en="Address" data-gu="સરનામું">Address</strong>
              <p data-en="Shubhanpura Area, Vadodara (Baroda), Gujarat – 390023" data-gu="શુભાનપુરા વિસ્તાર, વડોદરા (બરોડા), ગુજરાત – 390023">Shubhanpura Area, Vadodara (Baroda), Gujarat – 390023</p>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
            <div>
              <strong data-en="Phone" data-gu="ફોન">Phone</strong>
              <p><a href="tel:+919574659456" class="contact-link">+91 XXXXX XXXXX</a></p>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="contact-icon"><i class="bi bi-whatsapp"></i></div>
            <div>
              <strong>WhatsApp</strong>
              <p>
                <a href="https://wa.me/919574659456" class="btn btn-whatsapp-sm" target="_blank" rel="noopener noreferrer" data-en="Chat on WhatsApp" data-gu="WhatsApp પર ચેટ">
                  <i class="bi bi-whatsapp me-1"></i>Chat on WhatsApp
                </a>
              </p>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="contact-icon"><i class="bi bi-clock-fill"></i></div>
            <div>
              <strong data-en="Business Hours" data-gu="વ્યવસાય સમય">Business Hours</strong>
              <p data-en="Mon–Sat: 7:00 AM – 9:00 PM" data-gu="સોમ–શનિ: સવારે 7:00 – રાત 9:00">Mon–Sat: 7:00 AM – 9:00 PM</p>
              <p data-en="Sunday: 7:00 AM – 1:00 PM" data-gu="રવિ: સવારે 7:00 – બપોરે 1:00">Sunday: 7:00 AM – 1:00 PM</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <div class="contact-form-card">
          <h3 class="mb-4" data-en="Send Us a Message" data-gu="અમને સંદેશ મોકલો">Send Us a Message</h3>
          <form id="contactForm" novalidate aria-label="Contact form">
            @csrf
            {{-- Honeypot anti-spam --}}
            <input type="text" name="website" class="hp-field" tabindex="-1" autocomplete="off" aria-hidden="true" />
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="contactName" class="form-label" data-en="Your Name *" data-gu="તમારું નામ *">Your Name *</label>
                <input type="text" class="form-control" id="contactName" name="name" required minlength="2" maxlength="60" autocomplete="name" placeholder="Rameshbhai Patel" />
                <div class="invalid-feedback" data-en="Please enter your name (2-60 characters)." data-gu="કૃપા કરી નામ દાખલ કરો.">Please enter your name.</div>
              </div>
              <div class="col-sm-6">
                <label for="contactPhone" class="form-label" data-en="Phone Number *" data-gu="ફોન નંબર *">Phone Number *</label>
                <input type="tel" class="form-control" id="contactPhone" name="phone" required pattern="[0-9]{10}" maxlength="10" autocomplete="tel" placeholder="9876543210" />
                <div class="invalid-feedback" data-en="Please enter a valid 10-digit phone number." data-gu="10 અંકનો ફોન નંબર.">Please enter a valid 10-digit number.</div>
              </div>
              <div class="col-12">
                <label for="contactEmail" class="form-label" data-en="Email (Optional)" data-gu="ઇ-મેઇલ (વૈકલ્પિક)">Email (Optional)</label>
                <input type="email" class="form-control" id="contactEmail" name="email" maxlength="100" autocomplete="email" placeholder="your@email.com" />
                <div class="invalid-feedback" data-en="Please enter a valid email." data-gu="યોગ્ય ઇ-મેઇલ.">Please enter a valid email.</div>
              </div>
              <div class="col-12">
                <label for="contactSubject" class="form-label" data-en="Order Type" data-gu="ઓર્ડરનો પ્રકાર">Order Type</label>
                <select class="form-select" id="contactSubject" name="subject">
                  <option value="" data-en="Select order type..." data-gu="ઓર્ડર પ્રકાર...">Select order type...</option>
                  <option value="retail"    data-en="Retail Order"              data-gu="છૂટક ઓર્ડર">Retail Order</option>
                  <option value="wholesale" data-en="Wholesale / Bulk Order"   data-gu="જથ્થાબંધ ઓર્ડર">Wholesale / Bulk Order</option>
                  <option value="wedding"   data-en="Wedding / Event Catering" data-gu="લગ્ન / ઇવેન્ટ">Wedding / Event Catering</option>
                  <option value="inquiry"   data-en="General Inquiry"          data-gu="સામાન્ય ઇન્ક્વાયરી">General Inquiry</option>
                </select>
              </div>
              <div class="col-12">
                <label for="contactMessage" class="form-label" data-en="Message *" data-gu="સંદેશ *">Message *</label>
                <textarea class="form-control" id="contactMessage" name="message" rows="4" required minlength="10" maxlength="500" placeholder="Tell us what you need..."></textarea>
                <div class="invalid-feedback" data-en="Please enter a message (10-500 characters)." data-gu="સંદેશ દાખલ કરો.">Please enter a message.</div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary-custom w-100 btn-lg" id="submitBtn">
                  <span class="btn-text" data-en="Send Message" data-gu="સંદેશ મોકલો"><i class="bi bi-send me-2"></i>Send Message</span>
                  <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span><span data-en="Sending..." data-gu="મોકલી રહ્યા...">Sending...</span></span>
                </button>
              </div>
              <div class="col-12">
                <div id="formMsg" class="form-message d-none" role="alert" aria-live="polite"></div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-12" data-aos="fade-up">
        <div class="map-wrap rounded-4 overflow-hidden">
          <iframe
            title="Bhramani Khandavi House on Google Maps"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14742.64839786!2d73.1706!3d22.3219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395fc5873b0edb31%3A0xb06e56c28d041ca6!2sShubhanpura%2C%20Vadodara%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1699000000000!5m2!1sen!2sin"
            width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            aria-label="Map showing Shubhanpura, Vadodara"></iframe>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ===================== FOOTER ===================== --}}
<footer class="site-footer" aria-label="Site footer">
  <div class="footer-top">
    <div class="container">
      <div class="row g-4">

        <div class="col-lg-4 col-md-6">
          <div class="footer-brand d-flex align-items-center gap-2 mb-3">
            <svg width="38" height="38" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <circle cx="21" cy="21" r="21" fill="#FF9933"/>
              <text x="21" y="27" text-anchor="middle" font-size="20" font-family="serif" fill="white">ભ</text>
            </svg>
            <div>
              <span class="footer-brand-name" data-en="Bhramani Khandavi House" data-gu="બ્રાહ્માણી ખાંડવી હાઉસ">Bhramani Khandavi House</span>
              <small class="d-block" data-en="Authentic Gujarati Farsan" data-gu="અસલી ગુજરાતી ફરસાણ">Authentic Gujarati Farsan</small>
            </div>
          </div>
          <p class="footer-text" data-en="Serving the most authentic and fresh Gujarati Farsan in Shubhanpura, Vadodara. Your happiness is our greatest recipe." data-gu="શુભાનપુરા, વડોદરામાં સૌથી અસલી ગુજરાતી ફરસાણ. તમારી ખુશી અમારી ઉત્તમ રેસિપી.">
            Serving the most authentic and fresh Gujarati Farsan in Shubhanpura, Vadodara.
          </p>
          <div class="social-links mt-3" aria-label="Social media links">
            <a href="https://wa.me/919574659456" class="social-btn" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <a href="#" class="social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
          <h4 class="footer-heading" data-en="Quick Links" data-gu="ઝડપી લિંક">Quick Links</h4>
          <ul class="footer-links" role="list">
            <li><a href="#home"        data-en="Home"       data-gu="હોમ">Home</a></li>
            <li><a href="#about"       data-en="About Us"   data-gu="અમારા વિશે">About Us</a></li>
            <li><a href="#products"    data-en="Products"   data-gu="ઉત્પાદનો">Products</a></li>
            <li><a href="#wholesale"   data-en="Wholesale"  data-gu="જથ્થાબંધ">Wholesale</a></li>
            <li><a href="#gallery"     data-en="Gallery"    data-gu="ગેલેરી">Gallery</a></li>
            <li><a href="#contact"     data-en="Contact"    data-gu="સંપર્ક">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
          <h4 class="footer-heading" data-en="Our Products" data-gu="અમારા ઉત્પાદનો">Our Products</h4>
          <ul class="footer-links" role="list">
            <li><a href="#products" data-en="Khandavi"   data-gu="ખાંડવી">Khandavi</a></li>
            <li><a href="#products" data-en="Samosa"     data-gu="સામોસા">Samosa</a></li>
            <li><a href="#products" data-en="Khaman"     data-gu="ખમણ">Khaman</a></li>
            <li><a href="#products" data-en="Patra"      data-gu="પાત્રા">Patra</a></li>
            <li><a href="#products" data-en="Dhokla"     data-gu="ઢોકળા">Dhokla</a></li>
            <li><a href="#products" data-en="Mix Farsan" data-gu="મિક્સ ફરસાણ">Mix Farsan</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4 class="footer-heading" data-en="Business Hours" data-gu="વ્યવસાય સમય">Business Hours</h4>
          <ul class="footer-hours" role="list">
            <li>
              <span data-en="Monday – Saturday" data-gu="સોમ – શનિ">Monday – Saturday</span>
              <span>7:00 AM – 9:00 PM</span>
            </li>
            <li>
              <span data-en="Sunday" data-gu="રવિ">Sunday</span>
              <span>7:00 AM – 1:00 PM</span>
            </li>
          </ul>
          <a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order" class="btn btn-wa-footer mt-3" target="_blank" rel="noopener noreferrer" data-en="Order on WhatsApp" data-gu="WhatsApp પર ઓર્ડર">
            <i class="bi bi-whatsapp me-2"></i>Order on WhatsApp
          </a>
        </div>

      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
      <p class="mb-0">
        &copy; <span id="currentYear"></span>
        <span data-en="Bhramani Khandavi House. All Rights Reserved." data-gu="બ્રાહ્માણી ખાંડવી હાઉસ. સર્વ અધિકાર સુરક્ષિત.">Bhramani Khandavi House. All Rights Reserved.</span>
      </p>
      <p class="mb-0 footer-made">
        <span data-en="Made with" data-gu="બનાવ્યું">Made with</span>
        <i class="bi bi-heart-fill text-saffron" aria-hidden="true"></i>
        <span data-en="in Vadodara, Gujarat" data-gu="વડોદરા, ગુજરાતમાં">in Vadodara, Gujarat</span>
      </p>
    </div>
  </div>
</footer>

{{-- ===================== FLOATING BUTTONS ===================== --}}
<a href="https://wa.me/919574659456?text=Hello%2C%20I%20want%20to%20order%20Farsan" class="float-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
  <i class="bi bi-whatsapp" aria-hidden="true"></i>
</a>
<button class="back-to-top" id="backToTop" aria-label="Back to top">
  <i class="bi bi-chevron-up" aria-hidden="true"></i>
</button>

{{-- ===================== SCRIPTS ===================== --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>

{{-- JS files from public/js/ --}}
<script src="{{ asset('js/webpage-translations.js') }}" defer></script>
<script src="{{ asset('js/webpage-main.js') }}" defer></script>

</body>
</html>
