@php
    $pageTitle = trim($__env->yieldContent('title', 'LUXE ROTATE | Thuê & mua thời trang cao cấp'));
    $pageDescription = trim($__env->yieldContent('meta_description', 'Nền tảng thuê và mua trang phục thiết kế cao cấp với lịch trống minh bạch, AI Stylist và cơ chế bảo vệ tiền cọc.'));
    $canonicalUrl = trim($__env->yieldContent('canonical', url()->current()));
    $robots = trim($__env->yieldContent('robots', 'index, follow, max-image-preview:large'));
    $openGraphType = trim($__env->yieldContent('og_type', 'website'));
    $openGraphImage = trim($__env->yieldContent('og_image', asset('images/editorial/hero-campaign.webp')));
    $openGraphImageAlt = trim($__env->yieldContent('og_image_alt', 'Bộ sưu tập thời trang cao cấp của LUXE ROTATE'));
    $pageBreadcrumbs = $breadcrumbs ?? [
        ['name' => 'Trang chủ', 'url' => route('home')],
    ];

    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'LUXE ROTATE',
        'url' => route('home'),
        'description' => $pageDescription,
        'inLanguage' => 'vi-VN',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => route('search').'?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($pageBreadcrumbs)->values()->map(fn (array $breadcrumb, int $index): array => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $breadcrumb['name'],
            'item' => $breadcrumb['url'],
        ])->all(),
    ];
@endphp

<!doctype html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0A0A0A">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="{{ $openGraphType }}">
    <meta property="og:site_name" content="LUXE ROTATE">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $openGraphImage }}">
    <meta property="og:image:alt" content="{{ $openGraphImageAlt }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $openGraphImage }}">
    <meta name="twitter:image:alt" content="{{ $openGraphImageAlt }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('fonts/Inter-400-vietnamese.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/PlayfairDisplay-400-vietnamese.woff2') }}" as="font" type="font/woff2" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    <script type="application/ld+json">{!! json_encode($websiteSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @stack('structured-data')
</head>
<body class="min-h-screen overflow-x-hidden bg-paper text-ink antialiased">
    <a href="#main-content" class="sr-only z-[100] bg-ink px-4 py-3 text-sm text-paper focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Chuyển đến nội dung chính
    </a>

    <x-client::header />

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    @include('client.partials.footer')
    @stack('scripts')
</body>
</html>