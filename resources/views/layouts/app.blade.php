<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- =========================================================
     PAGE TITLE
     ========================================================= -->
<title>@yield('title', 'EnglishTraveller')</title>

<!-- =========================================================
     FAVICON
     ========================================================= -->
<link rel="icon"
      href="{{ asset('images/faicon.png') }}"
      type="image/png">

<!-- =========================================================
     SEO
     ========================================================= -->
<meta name="description"
      content="@yield('meta_description', 'Looking for affordable flight deals? Book with EnglishTraveller.')">

<meta name="keywords"
      content="@yield('meta_keywords', 'Flight Booking, Cheap Flights, Airline Tickets')">

<meta name="robots"
      content="@yield('robots', 'index, follow')">

<!-- Google Search Console -->
<meta name="google-site-verification"
      content="54Ckka9897zZ3KsX_7eu1uDnVJV__-MrcrYWh8HLmgk">

<!-- =========================================================
     CANONICAL
     FIX: url()->current() excludes query strings (?utm_...),
     so tracking parameters no longer create duplicate canonicals.
     ========================================================= -->
<link rel="canonical"
      href="@yield('canonical', url()->current())">

<!-- =========================================================
     OPEN GRAPH
     ========================================================= -->
<meta property="og:type"
      content="@yield('og_type', 'website')">

<meta property="og:url"
      content="@yield('og_url', url()->current())">

<meta property="og:title"
      content="@yield('og_title', 'EnglishTraveller')">

<meta property="og:description"
      content="@yield('og_description', 'Looking for affordable flight deals? Book with EnglishTraveller.')">

<meta property="og:image"
      content="@yield('og_image', asset('images/og-image.jpg'))">

<!-- =========================================================
     MAIN CSS (moved up so it is discovered first)
     Order kept the same as before relative to Bootstrap
     (style.css, then Bootstrap) so your layout does not change.
     ========================================================= -->
<link rel="stylesheet"
      href="{{ asset('css/style.css') }}?v=3">

<!-- =========================================================
     BOOTSTRAP CSS
     FIX: removed the redundant <link rel="preload"> - a normal
     stylesheet link is already discovered and fetched immediately.
     TIP: self-host this file (/css/bootstrap.min.css) to remove
     the cross-origin connection cost.
     ========================================================= -->
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

<!-- =========================================================
     PAGE-SPECIFIC PRELOADS
     FIX: only the current page's hero/LCP image is preloaded.
     Each page pushes its own image, e.g.:
       @push('preloads')
         <link rel="preload" as="image" href="..." fetchpriority="high">
       @endpush
     ========================================================= -->
@stack('preloads')

<!-- =========================================================
     PRECONNECT
     FIX: removed googletagmanager.com (GA loads 1s after window
     load, so an early connection was wasted).
     ========================================================= -->

<!-- jsDelivr - Bootstrap JS / Swiper -->
<link rel="preconnect"
      href="https://cdn.jsdelivr.net"
      crossorigin>

<!-- Font Awesome (remove if icons are self-hosted) -->
<link rel="preconnect"
      href="https://use.fontawesome.com"
      crossorigin>

<!-- =========================================================
     FONT AWESOME
     Non-critical CSS - loaded asynchronously.
     ========================================================= -->
<link rel="preload"
      href="https://use.fontawesome.com/releases/v6.5.2/css/all.css"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">

<noscript>
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v6.5.2/css/all.css">
</noscript>

<!-- =========================================================
     SWIPER CSS
     Non-critical unless the hero itself uses Swiper.
     ========================================================= -->
<link rel="preload"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">

<noscript>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</noscript>

<!-- =========================================================
     STRUCTURED DATA (JSON-LD)
     ========================================================= -->
@php
    $siteUrl = rtrim(config('app.url'), '/');

    $defaultDescription = 'Looking for affordable flight deals? Book with EnglishTraveller.';

    // Description set by the current page via @section('meta_description', '...')
    $pageDescription = trim(html_entity_decode(strip_tags($__env->yieldContent('meta_description')))) ?: $defaultDescription;

    // On the homepage use its own description; inner pages fall back to the default.
    $organizationDescription = request()->is('/') ? $pageDescription : $defaultDescription;

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            [
                '@type'       => 'TravelAgency',
                '@id'         => $siteUrl . '/#organization',
                'name'        => 'EnglishTraveller',
                'url'         => $siteUrl . '/',
                'logo'        => [
                    '@type' => 'ImageObject',
                    'url'   => asset('images/logo.png'), // must be a real file
                ],
                'image'       => asset('images/og-image.jpg'),
                'description' => $organizationDescription,
            ],
            [
                '@type'       => 'WebSite',
                '@id'         => $siteUrl . '/#website',
                'url'         => $siteUrl . '/',
                'name'        => 'EnglishTraveller',
                'description' => $organizationDescription,
                'publisher'   => ['@id' => $siteUrl . '/#organization'],
                'inLanguage'  => 'en-US',
            ],
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT) !!}
</script>

{{-- Page-specific schema (Article, FAQ, Breadcrumb, etc.) --}}
@stack('schema')

<!-- =========================================================
     GOOGLE ANALYTICS
     Config runs immediately; the gtag.js file itself is loaded
     1s after window load so it stays out of the critical path.
     ========================================================= -->
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'G-ZRDQLGJNZ6');

    window.addEventListener('load', function () {
        setTimeout(function () {
            if (window.googleAnalyticsLoaded) {
                return;
            }

            window.googleAnalyticsLoaded = true;

            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://www.googletagmanager.com/gtag/js?id=G-ZRDQLGJNZ6';
            document.head.appendChild(script);
        }, 1000);
    });
</script>

<!-- =========================================================
     PAGE-SPECIFIC CSS
     ========================================================= -->
@stack('styles')

</head>

<body>

@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')

<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    defer>
</script>

<!-- Swiper JS -->
<script
    src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"
    defer>
</script>

<!-- Custom JS -->
<script
    src="{{ asset('js/main.js') }}?v=2"
    defer>
</script>

<!-- Page-specific JavaScript -->
@stack('scripts')

</body>
</html>