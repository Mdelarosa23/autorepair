@php
    $seo = array_merge($siteSeoDefaults ?? [], $seo ?? []);
    $siteName = $siteBusiness['name'] ?? config('app.name');
    $seoTitle = $seo['title'] ?? $siteName;
    $seoDescription = $seo['description'] ?? null;
    $seoKeywords = $seo['keywords'] ?? null;
    $seoType = $seo['type'] ?? 'website';
    $seoImage = $seo['image'] ?? asset('assets/img/logo.png');
    $canonicalUrl = $seo['canonical'] ?? url()->current();
    $businessSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'AutoRepair',
        'name' => $siteBusiness['name'] ?? null,
        'url' => url('/'),
        'image' => $seoImage,
        'telephone' => $siteBusiness['phone'] ?? null,
        'email' => $siteBusiness['email'] ?? null,
        'priceRange' => '$$',
        'address' => array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $siteBusiness['street_address'] ?? null,
            'addressLocality' => $siteBusiness['city'] ?? null,
            'addressRegion' => $siteBusiness['state'] ?? null,
            'postalCode' => $siteBusiness['postal_code'] ?? null,
            'addressCountry' => $siteBusiness['country'] ?? null,
        ]),
        'openingHours' => $siteBusiness['hours'] ?? null,
    ]);
@endphp

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index,follow">
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="author" content="{{ $siteName }}">
<link rel="canonical" href="{{ $canonicalUrl }}">
{{-- <base href="{{ asset('mads-template') }}/"> --}}

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<!-- Meanmenu CSS -->
<link rel="stylesheet" href="assets/css/meanmenu.css">
<!-- Boxicons CSS -->
<link rel="stylesheet" href="assets/css/boxicons.min.css">
<!-- Owl Carousel -->
<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="assets/css/magnific-popup.min.css">
<!-- Animate CSS -->
<link rel="stylesheet" href="assets/css/animate.min.css">
<!-- Template CSS -->
{{-- <link rel="stylesheet" href="assets/css/style.css"> --}}
@include('components.style')
<link rel="stylesheet" href="assets/css/responsive.css">
{{-- <link rel="stylesheet" href="assets/css/theme-dark.css"> --}}


@include('components.dark')

{{-- <!-- Easy-to-edit theme override files -->
<link rel="stylesheet" href="assets/css/theme-light-edit.css">
<link rel="stylesheet" href="assets/css/theme-dark-edit.css"> --}}
<meta property="og:locale" content="en_US">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">

<title>{{ $seoTitle }}</title>

<link rel="icon" type="image/png" href="assets/img/logo.png">
<script type="application/ld+json">{!! json_encode($businessSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
