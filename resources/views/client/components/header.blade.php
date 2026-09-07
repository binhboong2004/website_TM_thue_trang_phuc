@php
    $megaMenus = [
        'rent' => [
            'label' => 'Thuê',
            'url' => route('client.shop', ['type' => 'rent']),
            'is_active' => request()->routeIs('client.shop') && (request('type') === 'rent' || request('transaction') === 'rental'),
            'eyebrow' => 'Rental edit',
            'headline' => 'Thuê cho khoảnh khắc đáng nhớ',
            'description' => 'Chọn ngày mặc, giữ lịch và bảo vệ tiền cọc trong một quy trình minh bạch.',
            'cta' => ['label' => 'Xem toàn bộ đồ thuê', 'url' => route('client.shop', ['type' => 'rent'])],
            'columns' => [
                ['title' => 'Theo dịp', 'links' => [
                    ['label' => 'Tiệc cưới', 'url' => route('collections.show', 'tiec-cuoi')],
                    ['label' => 'Dạ tiệc', 'url' => route('collections.show', 'da-tiec')],
                    ['label' => 'Sự kiện công sở', 'url' => route('collections.show', 'cong-so')],
                    ['label' => 'Kỳ nghỉ', 'url' => route('collections.show', 'ky-nghi')],
                ]],
                ['title' => 'Danh mục', 'links' => [
                    ['label' => 'Váy dạ hội', 'url' => route('collections.show', 'vay-da-hoi')],
                    ['label' => 'Suit & Tuxedo', 'url' => route('collections.show', 'suit-tuxedo')],
                    ['label' => 'Phụ kiện', 'url' => route('collections.show', 'phu-kien')],
                    ['label' => 'Thiết kế mới', 'url' => route('collections.show', 'thiet-ke-moi')],
                ]],
            ],
        ],
        'buy' => [
            'label' => 'Mua',
            'url' => route('client.shop', ['type' => 'buy']),
            'is_active' => request()->routeIs('client.shop') && (request('type') === 'buy' || request('transaction') === 'purchase'),
            'eyebrow' => 'Permanent wardrobe',
            'headline' => 'Những thiết kế để sở hữu lâu dài',
            'description' => 'Mua đứt sản phẩm chính hãng từ các gian hàng và atelier đã được kiểm duyệt.',
            'cta' => ['label' => 'Mua sắm tất cả', 'url' => route('client.shop', ['type' => 'buy'])],
            'columns' => [
                ['title' => 'Nữ', 'links' => [
                    ['label' => 'Đầm & váy', 'url' => route('collections.show', 'dam-vay')],
                    ['label' => 'Áo khoác', 'url' => route('collections.show', 'ao-khoac-nu')],
                    ['label' => 'Suit nữ', 'url' => route('collections.show', 'suit-nu')],
                    ['label' => 'Phụ kiện nữ', 'url' => route('collections.show', 'phu-kien-nu')],
                ]],
                ['title' => 'Nam', 'links' => [
                    ['label' => 'Suit & Tuxedo', 'url' => route('collections.show', 'suit-tuxedo-nam')],
                    ['label' => 'Áo khoác', 'url' => route('collections.show', 'ao-khoac-nam')],
                    ['label' => 'Sơ mi', 'url' => route('collections.show', 'so-mi-nam')],
                    ['label' => 'Phụ kiện nam', 'url' => route('collections.show', 'phu-kien-nam')],
                ]],
            ],
        ],
        'brands' => [
            'label' => 'Thương hiệu',
            'url' => route('client.brands'),
            'is_active' => request()->routeIs('client.brands*'),
            'eyebrow' => 'Designer index',
            'headline' => 'Nhà mốt quốc tế & thiết kế Việt',
            'description' => 'Khám phá tuyển chọn từ Saint Laurent, Dior đến những atelier Việt Nam đương đại.',
            'cta' => ['label' => 'Danh mục thương hiệu', 'url' => route('client.brands')],
            'columns' => [
                ['title' => 'Quốc tế', 'links' => [
                    ['label' => 'Saint Laurent', 'url' => route('client.brands.show', 'saint-laurent')],
                    ['label' => 'Dior', 'url' => route('client.brands.show', 'dior')],
                    ['label' => 'Prada', 'url' => route('client.brands.show', 'prada')],
                    ['label' => 'Alexander McQueen', 'url' => route('client.brands.show', 'alexander-mcqueen')],
                ]],
                ['title' => 'Việt Nam', 'links' => [
                    ['label' => 'Công Trí', 'url' => route('client.brands.show', 'cong-tri')],
                    ['label' => 'Lâm Gia Khang', 'url' => route('client.brands.show', 'lam-gia-khang')],
                    ['label' => 'Đỗ Mạnh Cường', 'url' => route('client.brands.show', 'do-manh-cuong')],
                    ['label' => 'Tất cả nhà thiết kế', 'url' => route('client.brands')],
                ]],
            ],
        ],
    ];
@endphp

<div x-data="siteHeader" class="contents" @keydown.escape.window="closeMegaMenu(); closeSearch(); mobileMenuOpen = false">
    <div class="announcement-bar" aria-label="Miễn phí giao nhận nội thành cho đơn thuê từ 1.500.000₫. Di chuột hoặc đặt tiêu điểm để tạm dừng." tabindex="0">
        <span class="sr-only">Miễn phí giao nhận nội thành cho đơn thuê từ 1.500.000₫</span>
        <div class="announcement-track" aria-hidden="true">
            @foreach (range(1, 2) as $iteration)
                <div class="announcement-group">
                    @foreach (range(1, 3) as $message)
                        <span class="announcement-message">
                            Miễn phí giao nhận nội thành cho đơn thuê từ 1.500.000₫
                            <span class="announcement-separator"></span>
                        </span>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <header class="sticky top-0 z-50 w-full bg-white border-b border-neutral-100 transition-all duration-300" @click.outside="closeMegaMenu(); closeSearch()" @mouseleave="closeMegaMenu()">
        <div class="shell grid h-[4.5rem] grid-cols-[2.75rem_1fr_auto] items-center gap-2 lg:grid-cols-[1fr_auto_1fr] lg:gap-8">
            <button
                type="button"
                class="flex size-11 items-center justify-start lg:hidden"
                aria-label="Mở menu điều hướng"
                aria-controls="mobile-navigation"
                :aria-expanded="mobileMenuOpen"
                @click="mobileMenuOpen = true; closeSearch()"
            >
                <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7h18M3 12h18M3 17h18" /></svg>
            </button>

            <a href="{{ route('home') }}" class="justify-self-center whitespace-nowrap font-display text-[1.05rem] tracking-[0.2em] lg:justify-self-start lg:text-xl" aria-label="LUXE ROTATE, về trang chủ">
                LUXE<span class="font-sans text-[0.65em]">/</span>ROTATE
            </a>

            <nav class="hidden justify-self-center lg:block" aria-label="Điều hướng chính">
                <ul class="flex items-center gap-7 text-xs font-semibold uppercase tracking-[0.14em] xl:gap-9 xl:text-[13px]">
                    @foreach ($megaMenus as $menuKey => $menu)
                        <li>
                            <a
                                href="{{ $menu['url'] }}"
                                class="nav-underline flex min-h-11 items-center gap-1.5 py-4 {{ $menu['is_active'] ? 'is-active' : '' }}"
                                aria-controls="mega-menu-{{ $menuKey }}"
                                aria-haspopup="true"
                                :aria-expanded="activeMegaMenu === '{{ $menuKey }}'"
                                @mouseenter="activeMegaMenu = '{{ $menuKey }}'"
                                @focus="activeMegaMenu = '{{ $menuKey }}'"
                                @keydown.arrow-down.prevent="activeMegaMenu = '{{ $menuKey }}'"
                            >
                                {{ $menu['label'] }}
                                <svg aria-hidden="true" class="size-3 transition-transform duration-200 motion-reduce:transition-none" :class="activeMegaMenu === '{{ $menuKey }}' && 'rotate-180'" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 4.5 3 3 3-3" /></svg>
                            </a>
                        </li>
                    @endforeach
                    <li><a class="nav-underline flex min-h-11 items-center py-4 {{ request()->routeIs('client.lookbook') ? 'is-active' : '' }}" href="{{ route('client.lookbook') }}">Lookbook</a></li>
                    <li><a class="nav-underline flex min-h-11 items-center py-4 {{ request()->routeIs('client.virtual-fitting') ? 'is-active' : '' }}" href="{{ route('client.virtual-fitting') }}">Thử đồ ảo</a></li>
                </ul>
            </nav>

            <div class="flex items-center justify-self-end">
                <button
                    type="button"
                    class="flex size-11 items-center justify-center"
                    aria-label="Mở tìm kiếm"
                    :aria-expanded="searchOpen"
                    aria-controls="header-search"
                    @click="searchOpen ? closeSearch() : openSearch()"
                >
                    <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="6.5" />
                        <path d="m16 16 4.5 4.5" />
                    </svg>
                </button>

                @guest
                    <div
                        x-data="{ userMenuOpen: false }"
                        class="relative flex h-full items-center"
                        @mouseenter="userMenuOpen = true"
                        @mouseleave="userMenuOpen = false"
                        @focusin="userMenuOpen = true"
                        @focusout="if (!$el.contains($event.relatedTarget)) userMenuOpen = false"
                        @click.outside="userMenuOpen = false"
                        @keydown.escape.stop="userMenuOpen = false; $refs.userMenuTrigger.focus()"
                    >
                        <button
                            x-ref="userMenuTrigger"
                            type="button"
                            class="flex size-11 cursor-pointer items-center justify-center text-black transition-colors duration-200 hover:text-neutral-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black motion-reduce:transition-none"
                            aria-label="Mở menu đăng nhập và đăng ký"
                            aria-haspopup="menu"
                            aria-controls="user-account-menu"
                            :aria-expanded="userMenuOpen"
                            @click="userMenuOpen = !userMenuOpen"
                            @keydown.arrow-down.prevent="userMenuOpen = true; $nextTick(() => $refs.firstUserMenuItem.focus())"
                        >
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4.5 21a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </button>

                        <div
                            x-show="userMenuOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
                            x-transition:enter-start="translate-y-2 opacity-0"
                            x-transition:enter-end="translate-y-0 opacity-100"
                            x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
                            x-transition:leave-start="translate-y-0 opacity-100"
                            x-transition:leave-end="translate-y-2 opacity-0"
                            class="absolute top-full right-0 z-50 mt-2"
                        >
                            <div class="pt-4">
                                <div id="user-account-menu" class="w-36 rounded-none border border-neutral-200 bg-white shadow-xl" role="menu" aria-label="Menu tài khoản">
                                    <a
                                        x-ref="firstUserMenuItem"
                                        href="{{ route('login') }}"
                                        class="block px-4 py-3 text-[10px] font-medium tracking-widest uppercase text-neutral-600 decoration-1 transition-all duration-200 hover:text-black hover:underline hover:underline-offset-4 focus-visible:text-black focus-visible:underline focus-visible:underline-offset-4 focus-visible:outline-none"
                                        role="menuitem"
                                    >
                                        Đăng nhập
                                    </a>
                                    <a
                                        href="{{ route('register') }}"
                                        class="block border-t border-neutral-100 px-4 py-3 text-[10px] font-medium tracking-widest uppercase text-neutral-600 decoration-1 transition-all duration-200 hover:text-black hover:underline hover:underline-offset-4 focus-visible:text-black focus-visible:underline focus-visible:underline-offset-4 focus-visible:outline-none"
                                        role="menuitem"
                                    >
                                        Đăng ký
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest

                @auth
                    @php
                        $user = Auth::user();
                    @endphp

                    <div
                        x-data="{ userMenuOpen: false }"
                        class="relative flex h-full items-center"
                        @mouseenter="userMenuOpen = true"
                        @mouseleave="userMenuOpen = false"
                        @focusin="userMenuOpen = true"
                        @focusout="if (!$el.contains($event.relatedTarget)) userMenuOpen = false"
                        @click.outside="userMenuOpen = false"
                        @keydown.escape.stop="userMenuOpen = false; $refs.userMenuTrigger.focus()"
                    >
                        <button
                            x-ref="userMenuTrigger"
                            type="button"
                            class="flex min-h-11 cursor-pointer items-center text-black transition-colors duration-200 hover:text-neutral-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black motion-reduce:transition-none"
                            aria-label="Mở menu tài khoản của {{ $user->name }}"
                            aria-haspopup="menu"
                            aria-controls="user-account-menu"
                            :aria-expanded="userMenuOpen"
                            @click="userMenuOpen = !userMenuOpen"
                            @keydown.arrow-down.prevent="userMenuOpen = true; $nextTick(() => $refs.firstUserMenuItem.focus())"
                        >
                            <img
                                src="{{ $user->avatar_url }}"
                                alt=""
                                width="28"
                                height="28"
                                class="h-7 w-7 shrink-0 rounded-full border border-neutral-200 object-cover"
                            >
                            <span class="ml-2 max-w-24 truncate text-[10px] font-medium uppercase tracking-widest text-neutral-800 sm:max-w-32" title="{{ $user->name }}">
                                {{ $user->name }}
                            </span>
                        </button>

                        <div
                            x-show="userMenuOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
                            x-transition:enter-start="translate-y-2 opacity-0"
                            x-transition:enter-end="translate-y-0 opacity-100"
                            x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
                            x-transition:leave-start="translate-y-0 opacity-100"
                            x-transition:leave-end="translate-y-2 opacity-0"
                            class="absolute top-full right-0 z-50 mt-2"
                        >
                            <div class="pt-4">
                                <div id="user-account-menu" class="w-48 rounded-none border border-neutral-200 bg-white shadow-xl" role="menu" aria-label="Menu tài khoản">
                                    <a
                                        x-ref="firstUserMenuItem"
                                        href="{{ Route::has('profile.edit') ? route('profile.edit') : url('/account/profile') }}"
                                        class="block px-4 py-2 text-left text-xs text-neutral-600 transition-colors duration-200 hover:bg-neutral-50 hover:text-black focus-visible:bg-neutral-50 focus-visible:text-black focus-visible:outline-none"
                                        role="menuitem"
                                    >
                                        Hồ sơ của tôi
                                    </a>
                                    <a
                                        href="{{ route('account.rentals.show', 'LR-2026-0001') }}#escrow-title"
                                        class="block px-4 py-2 text-left text-xs text-neutral-600 transition-colors duration-200 hover:bg-neutral-50 hover:text-black focus-visible:bg-neutral-50 focus-visible:text-black focus-visible:outline-none"
                                        role="menuitem"
                                    >
                                        Đơn thuê & Cọc
                                    </a>
                                    <a
                                        href="mailto:lookbook@luxerotate.vn?subject={{ rawurlencode('Chia sẻ phong cách cùng LUXE ROTATE') }}"
                                        class="block px-4 py-2 text-left text-xs text-neutral-600 transition-colors duration-200 hover:bg-neutral-50 hover:text-black focus-visible:bg-neutral-50 focus-visible:text-black focus-visible:outline-none"
                                        role="menuitem"
                                    >
                                        Đăng Lookbook
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="border-t border-neutral-100">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="block w-full cursor-pointer px-4 py-2 text-left text-xs text-neutral-600 transition-colors duration-200 hover:bg-neutral-50 hover:text-black focus-visible:bg-neutral-50 focus-visible:text-black focus-visible:outline-none"
                                            role="menuitem"
                                        >
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
                <button
                    type="button"
                    class="relative flex size-11 items-center justify-end sm:justify-center"
                    aria-label="Mở giỏ hàng"
                    @click="$dispatch('cart-drawer-open')"
                >
                    <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M5 8h14l-1 13H6L5 8Z" />
                        <path d="M9 9V6a3 3 0 0 1 6 0v3" />
                    </svg>
                    <span x-show="$store.cart.itemCount > 0" x-cloak class="absolute right-0.5 top-1 flex size-4 items-center justify-center bg-ink text-[8px] font-semibold text-paper" x-text="$store.cart.itemCount"></span>
                    <span class="sr-only" role="status" aria-atomic="true" x-text="$store.cart.itemCount + ' sản phẩm trong giỏ'"></span>
                </button>
            </div>
        </div>

        @foreach ($megaMenus as $menuKey => $menu)
            <section
                id="mega-menu-{{ $menuKey }}"
                x-show="activeMegaMenu === '{{ $menuKey }}'"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-x-0 top-full border-b border-line bg-paper"
                @mouseenter="activeMegaMenu = '{{ $menuKey }}'"
            >
                <div class="shell grid grid-cols-[1.05fr_0.95fr] gap-16 py-10 xl:py-12">
                    <div class="border-r border-line pr-14">
                        <p class="eyebrow text-muted">{{ $menu['eyebrow'] }}</p>
                        <h2 class="mt-4 max-w-xl font-display text-4xl leading-tight">{{ $menu['headline'] }}</h2>
                        <p class="mt-5 max-w-lg text-sm leading-7 text-muted">{{ $menu['description'] }}</p>
                        <a href="{{ $menu['cta']['url'] }}" class="text-link mt-6">{{ $menu['cta']['label'] }}</a>
                    </div>
                    <div class="grid grid-cols-2 gap-10">
                        @foreach ($menu['columns'] as $column)
                            <div>
                                <h3 class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">{{ $column['title'] }}</h3>
                                <ul class="mt-5 space-y-3.5 text-sm">
                                    @foreach ($column['links'] as $link)
                                        <li><a href="{{ $link['url'] }}" class="inline-flex min-h-8 items-center border-b border-transparent hover:border-ink">{{ $link['label'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach

        <section
            id="header-search"
            x-show="searchOpen"
            x-cloak
            x-transition.opacity.duration.150ms
            class="absolute inset-x-0 top-full border-b border-line bg-paper"
            aria-label="Tìm kiếm sản phẩm"
        >
            <div class="shell py-7 lg:py-9">
                <form method="GET" action="{{ route('search') }}" role="search" class="mx-auto max-w-4xl">
                    <label for="global-search" class="eyebrow text-muted">Bạn đang tìm thiết kế nào?</label>
                    <div class="mt-3 flex border-b border-ink">
                        <input
                            id="global-search"
                            x-ref="searchInput"
                            x-model="searchQuery"
                            name="q"
                            type="search"
                            autocomplete="off"
                            class="min-h-14 min-w-0 flex-1 bg-transparent py-3 pr-4 text-lg outline-none placeholder:text-muted/70 focus:outline-none sm:text-xl"
                            placeholder="Thử “váy dạ hội đen”"
                            role="combobox"
                            aria-autocomplete="list"
                            aria-controls="search-suggestions"
                            :aria-expanded="searchOpen"
                        >
                        <button type="submit" class="flex min-h-14 items-center gap-2 px-2 text-[10px] font-semibold uppercase tracking-[0.16em] sm:px-4">
                            Tìm kiếm
                            <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M14 7l5 5-5 5" /></svg>
                        </button>
                    </div>
                    <div id="search-suggestions" role="listbox" class="mt-4 grid gap-px bg-line sm:grid-cols-2">
                        <template x-for="suggestion in filteredSuggestions" :key="suggestion.url">
                            <a :href="suggestion.url" role="option" class="flex min-h-14 items-center justify-between gap-4 bg-paper px-4 text-sm hover:bg-fog">
                                <span x-text="suggestion.label"></span>
                                <span class="text-[10px] uppercase tracking-[0.12em] text-muted" x-text="suggestion.meta"></span>
                            </a>
                        </template>
                        <p x-show="filteredSuggestions.length === 0" class="col-span-full bg-paper px-4 py-5 text-sm text-muted" role="status">
                            Chưa có gợi ý phù hợp. Hãy thử tên danh mục, dịp mặc hoặc thương hiệu.
                        </p>
                    </div>
                </form>
            </div>
        </section>
    </header>

    <aside
        id="mobile-navigation"
        x-show="mobileMenuOpen"
        x-cloak
        x-trap.noscroll="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="fixed inset-0 z-[70] overflow-y-auto bg-paper lg:hidden"
        role="dialog"
        aria-modal="true"
        aria-label="Menu điều hướng"
    >
        <div class="flex min-h-dvh flex-col px-5 pb-8 pt-4 sm:px-8">
            <div class="flex items-center justify-between border-b border-line pb-4">
                <a href="{{ route('home') }}" class="font-display text-lg tracking-[0.2em]" @click="mobileMenuOpen = false">LUXE/ROTATE</a>
                <button type="button" class="flex size-11 items-center justify-end" aria-label="Đóng menu điều hướng" @click="mobileMenuOpen = false">
                    <svg aria-hidden="true" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 5l14 14M19 5 5 19" /></svg>
                </button>
            </div>

            <nav class="flex-1 py-8" aria-label="Điều hướng di động">
                <ul class="divide-y divide-line font-display text-[clamp(2rem,9vw,3.25rem)] leading-none">
                    <li><a href="{{ route('client.shop', ['type' => 'rent']) }}" class="flex min-h-20 items-center justify-between py-4" @click="mobileMenuOpen = false"><span>Thuê</span><span class="font-sans text-xs uppercase tracking-[0.14em] text-muted">Theo lịch</span></a></li>
                    <li><a href="{{ route('client.shop', ['type' => 'buy']) }}" class="flex min-h-20 items-center justify-between py-4" @click="mobileMenuOpen = false"><span>Mua</span><span class="font-sans text-xs uppercase tracking-[0.14em] text-muted">Sở hữu</span></a></li>
                    <li><a href="{{ route('client.brands') }}" class="flex min-h-20 items-center py-4" @click="mobileMenuOpen = false">Thương hiệu</a></li>
                    <li><a href="{{ route('client.lookbook') }}" class="flex min-h-20 items-center py-4" @click="mobileMenuOpen = false">Lookbook</a></li>
                    <li><a href="{{ route('client.virtual-fitting') }}" class="flex min-h-20 items-center py-4" @click="mobileMenuOpen = false">Thử đồ ảo</a></li>
                </ul>
            </nav>

            <div class="grid grid-cols-2 gap-px border-y border-line bg-line text-[10px] font-semibold uppercase tracking-[0.14em]">
                @guest
                    <a href="{{ route('login') }}" class="flex min-h-14 items-center bg-paper" @click="mobileMenuOpen = false">Đăng nhập</a>
                @else
                    <form method="POST" action="{{ route('logout') }}" class="flex min-h-14 items-center bg-paper">
                        @csrf
                        <button type="submit" class="flex min-h-14 w-full items-center">Đăng xuất</button>
                    </form>
                @endguest
                <button type="button" class="flex min-h-14 items-center justify-end bg-paper" @click="mobileMenuOpen = false; $dispatch('cart-drawer-open')">Giỏ hàng <span class="ml-2" x-text="`(${$store.cart.itemCount})`"></span></button>
            </div>
        </div>
    </aside>

    <x-client::cart-drawer />
</div>