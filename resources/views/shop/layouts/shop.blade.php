<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <meta name="theme-color" content="#0A0A0A">

    <title>@yield('title', 'Tổng quan') · LUXE ROTATE Shop</title>

    <link rel="preload" href="{{ asset('fonts/Inter-400-vietnamese.woff2') }}" as="font" type="font/woff2" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="min-h-screen bg-fog font-sans text-ink antialiased">
    <a href="#shop-main-content" class="sr-only z-[100] bg-ink px-4 py-3 text-sm text-paper focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Chuyển đến nội dung gian hàng
    </a>

    <x-shop::sidebar />

    <div class="min-h-screen lg:pl-72">
        @include('shop.partials.topbar')

        <main id="shop-main-content" tabindex="-1" class="px-4 py-8 sm:px-6 lg:px-10 lg:py-10">
            <div class="mx-auto max-w-[90rem]">
                @if (session('status'))
                    <div class="mb-6 border border-line bg-paper px-5 py-4 text-sm" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                @hasSection('page_header')
                    <header class="mb-8 border-b border-line pb-7 lg:mb-10">
                        @yield('page_header')
                    </header>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>