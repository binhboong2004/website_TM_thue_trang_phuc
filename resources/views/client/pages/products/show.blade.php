@extends('client.layouts.app')

@section('title', $product['name'].' | '.$product['brand'].' | LUXE ROTATE')
@section('meta_description', $product['description'].' Thuê theo lịch với cọc trung gian hoặc mua đứt chính hãng tại LUXE ROTATE.')
@section('canonical', $product['url'])
@section('og_type', 'product')
@section('og_image', $product['image'])
@section('og_image_alt', $product['name'].' của '.$product['brand'])

@php
    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product['name'],
        'description' => $product['description'],
        'sku' => $product['sku'],
        'image' => collect($product['gallery'])->pluck('src')->all(),
        'url' => $product['url'],
        'brand' => [
            '@type' => 'Brand',
            'name' => $product['brand'],
        ],
        'offers' => [
            [
                '@type' => 'Offer',
                'name' => 'Mua đứt',
                'url' => $product['url'].'#purchase-panel',
                'priceCurrency' => 'VND',
                'price' => $product['purchasePrice'],
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
            ],
            [
                '@type' => 'Offer',
                'name' => 'Thuê theo ngày',
                'url' => $product['url'].'#rental-panel',
                'priceCurrency' => 'VND',
                'price' => $product['rentalPrice'],
                'availability' => 'https://schema.org/InStock',
                'businessFunction' => 'http://purl.org/goodrelations/v1#LeaseOut',
                'priceSpecification' => [
                    '@type' => 'UnitPriceSpecification',
                    'priceCurrency' => 'VND',
                    'price' => $product['rentalPrice'],
                    'unitText' => 'DAY',
                ],
            ],
        ],
    ];

    $cartProduct = [
        'id' => $product['id'],
        'url' => $product['url'],
        'image' => $product['image'],
        'brand' => $product['brand'],
        'name' => $product['name'],
        'rentalPrice' => $product['rentalPrice'],
        'deposit' => $product['deposit'],
        'purchasePrice' => $product['purchasePrice'],
    ];

    $productDetailConfig = [
        'product' => $cartProduct,
        'sizes' => $product['sizes'],
        'unavailableDates' => $product['unavailableDates'],
    ];
@endphp

@push('structured-data')
    <script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    <article
        class="border-b border-line"
        x-data="productDetail(@js($productDetailConfig))"
        x-init="init()"
    >
        <div class="shell py-5 sm:py-7">
            <nav aria-label="Điều hướng phân cấp" class="flex flex-wrap items-center gap-2 text-[10px] font-medium uppercase tracking-[0.14em] text-muted">
                <a href="{{ route('home') }}" class="py-2 hover:text-ink">Trang chủ</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('client.shop') }}" class="py-2 hover:text-ink">Mua sắm</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink" aria-current="page">{{ $product['name'] }}</span>
            </nav>
        </div>

        <div class="shell grid min-w-0 gap-10 pb-20 lg:grid-cols-[minmax(0,1.12fr)_minmax(24rem,0.88fr)] lg:items-start lg:gap-14 xl:gap-20">
            <section aria-label="Thư viện ảnh {{ $product['name'] }}" class="min-w-0">
                <div class="grid min-w-0 gap-4 lg:grid-cols-[4.5rem_minmax(0,1fr)]">
                    <nav aria-label="Ảnh thu nhỏ sản phẩm" class="hidden lg:block">
                        <ol class="sticky top-28 space-y-3">
                            @foreach ($product['gallery'] as $index => $image)
                                <li>
                                    <a
                                        href="#product-image-{{ $index + 1 }}"
                                        class="block aspect-[3/4] overflow-hidden border border-line bg-fog transition-colors hover:border-ink focus-visible:border-ink"
                                        aria-label="Xem ảnh {{ $index + 1 }}: {{ $image['alt'] }}"
                                    >
                                        <img
                                            src="{{ $image['src'] }}"
                                            alt=""
                                            class="h-full w-full object-cover"
                                            style="object-position: {{ $image['position'] }}"
                                            width="144"
                                            height="192"
                                            loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                        >
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>

                    <div class="space-y-4">
                        @foreach ($product['gallery'] as $index => $image)
                            <figure
                                id="product-image-{{ $index + 1 }}"
                                class="relative scroll-mt-28 overflow-hidden bg-[#F7F7F7]"
                            >
                                <img
                                    src="{{ $image['src'] }}"
                                    alt="{{ $image['alt'] }}"
                                    class="aspect-[3/4] w-full object-cover"
                                    style="object-position: {{ $image['position'] }}"
                                    width="960"
                                    height="1280"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    decoding="async"
                                >

                                @if ($index === 0)
                                    <span class="absolute left-4 top-4 inline-flex min-h-9 items-center border border-neutral-300 bg-white/90 px-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-ink backdrop-blur-sm">
                                        Thử đồ ảo · VTON
                                    </span>
                                @endif

                                <figcaption class="sr-only">{{ $image['alt'] }}</figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>

            <section aria-labelledby="product-title" class="min-w-0 lg:sticky lg:top-28 lg:pr-1">
                <header class="border-b border-line pb-6">
                    <div class="flex items-start justify-between gap-6">
                        <div class="min-w-0">
                            <p class="eyebrow text-muted">{{ $product['brand'] }}</p>
                            <h1 id="product-title" class="mt-3 font-display text-4xl leading-tight text-ink sm:text-5xl">{{ $product['name'] }}</h1>
                        </div>
                        <button
                            type="button"
                            class="flex size-12 shrink-0 items-center justify-center rounded-full border border-line transition-colors hover:border-ink"
                            :aria-pressed="liked"
                            :aria-label="liked ? 'Xóa {{ $product['name'] }} khỏi yêu thích' : 'Thêm {{ $product['name'] }} vào yêu thích'"
                            @click="liked = !liked"
                        >
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="1.2">
                                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-muted">{{ $product['description'] }}</p>
                    <dl class="mt-5 flex flex-wrap gap-x-6 gap-y-2 text-xs">
                        <div class="flex gap-2"><dt class="text-muted">Mã thiết kế</dt><dd class="font-medium">{{ $product['sku'] }}</dd></div>
                        <div class="flex gap-2"><dt class="text-muted">Tình trạng</dt><dd class="font-medium">{{ $product['status'] }}</dd></div>
                    </dl>
                </header>

                <div class="mt-7">
                    <div class="grid grid-cols-2 border-b border-ink" role="tablist" aria-label="Chọn hình thức giao dịch">
                        <button
                            id="rental-tab"
                            type="button"
                            class="min-h-14 border-b-2 px-3 text-xs font-semibold uppercase tracking-[0.14em] transition-colors"
                            :class="activeTab === 'rental' ? 'border-ink bg-ink text-paper' : 'border-transparent bg-paper text-muted hover:text-ink'"
                            :aria-selected="activeTab === 'rental'"
                            aria-controls="rental-panel"
                            role="tab"
                            @click="activeTab = 'rental'"
                        >
                            Thuê sự kiện
                        </button>
                        <button
                            id="purchase-tab"
                            type="button"
                            class="min-h-14 border-b-2 px-3 text-xs font-semibold uppercase tracking-[0.14em] transition-colors"
                            :class="activeTab === 'purchase' ? 'border-ink bg-ink text-paper' : 'border-transparent bg-paper text-muted hover:text-ink'"
                            :aria-selected="activeTab === 'purchase'"
                            aria-controls="purchase-panel"
                            role="tab"
                            @click="activeTab = 'purchase'"
                        >
                            Mua đứt
                        </button>
                    </div>

                    <section
                        id="rental-panel"
                        class="pt-7"
                        role="tabpanel"
                        aria-labelledby="rental-tab"
                        x-show="activeTab === 'rental'"
                    >
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xs text-muted">Đơn giá thuê</p>
                                <p class="mt-1 text-2xl font-medium tabular-nums">{{ number_format($product['rentalPrice'], 0, ',', '.') }}đ <span class="text-sm font-normal text-muted">/ ngày</span></p>
                            </div>
                            <p class="text-right text-[10px] uppercase tracking-[0.14em] text-muted">Chọn ngày nhận và trả</p>
                        </div>

                        <section class="mt-7 border border-line p-4 sm:p-5" aria-labelledby="rental-calendar-title">
                            <header class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="eyebrow text-muted">Lịch khả dụng</p>
                                    <h2 id="rental-calendar-title" class="mt-1 font-sans text-sm font-medium">Chọn khoảng thuê</h2>
                                </div>
                                <div class="flex">
                                    <button
                                        type="button"
                                        class="flex size-11 items-center justify-center border border-line disabled:cursor-not-allowed disabled:opacity-30"
                                        :disabled="!canMovePrevious"
                                        aria-label="Xem hai tháng trước"
                                        @click="moveCalendar(-1)"
                                    >
                                        <svg aria-hidden="true" class="size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m10 3-5 5 5 5" /></svg>
                                    </button>
                                    <button
                                        type="button"
                                        class="-ml-px flex size-11 items-center justify-center border border-line"
                                        aria-label="Xem hai tháng sau"
                                        @click="moveCalendar(1)"
                                    >
                                        <svg aria-hidden="true" class="size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m6 3 5 5-5 5" /></svg>
                                    </button>
                                </div>
                            </header>

                            <div class="mt-5 grid gap-7 xl:grid-cols-2">
                                <template x-for="offset in [0, 1]" :key="offset">
                                    <section>
                                        <h3 class="font-sans text-center text-xs font-semibold uppercase tracking-[0.12em]" x-text="monthLabel(offset)"></h3>
                                        <div class="mt-4 grid grid-cols-7 text-center text-[10px] font-medium uppercase text-muted" aria-hidden="true">
                                            <span>T2</span><span>T3</span><span>T4</span><span>T5</span><span>T6</span><span>T7</span><span>CN</span>
                                        </div>
                                        <div class="mt-2 grid grid-cols-7 gap-0.5">
                                            <template x-for="day in monthDays(offset)" :key="day.key">
                                                <div>
                                                    <template x-if="day.blank">
                                                        <span class="block min-h-10" aria-hidden="true"></span>
                                                    </template>
                                                    <template x-if="!day.blank">
                                                        <button
                                                            type="button"
                                                            class="flex min-h-10 w-full items-center justify-center text-xs tabular-nums transition-colors disabled:cursor-not-allowed disabled:text-neutral-300 disabled:line-through"
                                                            :class="isBoundary(day.iso) ? 'bg-ink text-paper' : (isInRange(day.iso) ? 'bg-fog text-ink' : 'hover:bg-fog')"
                                                            :disabled="day.disabled"
                                                            :aria-label="day.label + (day.unavailable ? ', không khả dụng' : '')"
                                                            :aria-pressed="isBoundary(day.iso)"
                                                            @click="selectDate(day.iso)"
                                                            x-text="day.day"
                                                        ></button>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </section>
                                </template>
                            </div>

                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-4 text-xs">
                                <p class="text-muted">
                                    <span class="mr-2 inline-block size-2 bg-neutral-300"></span>
                                    Ngày gạch ngang đã được giữ lịch
                                </p>
                                <button type="button" class="min-h-11 font-semibold underline underline-offset-4" x-show="rentalStart" @click="clearDates()">Chọn lại ngày</button>
                            </div>
                        </section>

                        <div class="mt-6">
                            <div class="flex items-center justify-between gap-4">
                                <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.12em]">Chọn kích cỡ</h2>
                                <button type="button" class="min-h-11 text-xs font-semibold underline underline-offset-4" @click="openSizeModal()">AI tư vấn size</button>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($product['sizes'] as $size)
                                    <button
                                        type="button"
                                        class="flex min-h-12 min-w-14 items-center justify-center border px-4 text-xs font-medium transition-colors"
                                        :class="rentalSize === @js($size) ? 'border-ink bg-ink text-paper' : 'border-line bg-paper text-ink hover:border-ink'"
                                        :aria-pressed="rentalSize === @js($size)"
                                        @click="rentalSize = @js($size)"
                                    >
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <dl class="mt-7 space-y-3 border-y border-line py-5 text-sm tabular-nums">
                            <div class="flex justify-between gap-5">
                                <dt class="text-muted">Thời gian thuê</dt>
                                <dd class="text-right font-medium" x-text="rentalDays > 0 ? rentalDays + ' ngày' : 'Chưa chọn lịch'"></dd>
                            </div>
                            <div class="flex justify-between gap-5">
                                <dt class="text-muted">Tiền thuê</dt>
                                <dd class="text-right font-medium" x-text="formatCurrency(rentalTotal)"></dd>
                            </div>
                            <div class="flex justify-between gap-5">
                                <dt>
                                    <span class="block">Cọc trung gian</span>
                                    <span class="mt-1 block text-[10px] leading-4 text-muted">Đóng băng qua cổng thanh toán, không chuyển cho Shop</span>
                                </dt>
                                <dd class="text-right font-medium">{{ number_format($product['deposit'], 0, ',', '.') }}đ</dd>
                            </div>
                            <div class="flex justify-between gap-5 border-t border-line pt-3 text-base">
                                <dt class="font-medium">Tạm tính khi đặt</dt>
                                <dd class="font-semibold" x-text="formatCurrency(rentalTotal + product.deposit)"></dd>
                            </div>
                        </dl>

                        <p class="mt-4 min-h-5 text-xs text-muted" role="status" aria-live="polite" x-text="rentalSummary"></p>

                        <button
                            type="button"
                            class="button-primary mt-5 w-full disabled:cursor-not-allowed disabled:opacity-40"
                            :disabled="!rentalReady"
                            @click="addRentalToCart()"
                        >
                            Giữ lịch & thêm vào giỏ thuê
                        </button>
                    </section>

                    <section
                        id="purchase-panel"
                        class="pt-7"
                        role="tabpanel"
                        aria-labelledby="purchase-tab"
                        x-show="activeTab === 'purchase'"
                        x-cloak
                    >
                        <div class="border-b border-line pb-6">
                            <p class="text-xs text-muted">Giá bán chính thức</p>
                            <p class="mt-2 text-3xl font-medium tabular-nums">{{ number_format($product['purchasePrice'], 0, ',', '.') }}đ</p>
                            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-xs">
                                <p><span class="text-muted">Tình trạng:</span> <strong class="font-medium">{{ $product['condition'] }}</strong></p>
                                <p><span class="text-muted">Kho:</span> <strong class="font-medium">Sẵn sàng giao</strong></p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center justify-between gap-4">
                                <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.12em]">Chọn kích cỡ</h2>
                                <button type="button" class="min-h-11 text-xs font-semibold underline underline-offset-4" @click="openSizeModal()">AI tư vấn size</button>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($product['sizes'] as $size)
                                    <button
                                        type="button"
                                        class="flex min-h-12 min-w-14 items-center justify-center border px-4 text-xs font-medium transition-colors"
                                        :class="purchaseSize === @js($size) ? 'border-ink bg-ink text-paper' : 'border-line bg-paper text-ink hover:border-ink'"
                                        :aria-pressed="purchaseSize === @js($size)"
                                        @click="purchaseSize = @js($size)"
                                    >
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <button
                            type="button"
                            class="button-primary mt-7 w-full disabled:cursor-not-allowed disabled:opacity-40"
                            :disabled="purchaseSize === ''"
                            @click="addPurchaseToCart()"
                        >
                            Thêm vào giỏ mua đứt
                        </button>
                        <p class="mt-4 text-center text-xs leading-5 text-muted">Đổi size trong 03 ngày nếu sản phẩm còn nguyên tem và chưa qua sử dụng.</p>
                    </section>
                </div>

                <div class="mt-10 border-t border-ink">
                    <section x-data="{ open: true }" class="border-b border-line">
                        <button type="button" class="flex min-h-16 w-full items-center justify-between gap-4 py-4 text-left" :aria-expanded="open" aria-controls="measurement-content" @click="open = !open">
                            <span class="text-xs font-semibold uppercase tracking-[0.12em]">Bảng số đo trang phục</span>
                            <svg aria-hidden="true" class="size-4 transition-transform motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <div id="measurement-content" x-show="open" x-transition.opacity.duration.150ms class="pb-6">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[28rem] border-collapse text-left text-xs tabular-nums">
                                    <caption class="sr-only">Số đo ngực, eo, mông và chiều dài theo kích cỡ, đơn vị centimet</caption>
                                    <thead class="border-y border-line text-[10px] uppercase tracking-[0.1em] text-muted">
                                        <tr><th class="px-2 py-3 font-medium">Size</th><th class="px-2 py-3 font-medium">Ngực</th><th class="px-2 py-3 font-medium">Eo</th><th class="px-2 py-3 font-medium">Mông</th><th class="px-2 py-3 font-medium">Dài</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product['measurements'] as $size => $measurement)
                                            <tr class="border-b border-line"><th class="px-2 py-3 font-semibold">{{ $size }}</th><td class="px-2 py-3">{{ $measurement['bust'] }} cm</td><td class="px-2 py-3">{{ $measurement['waist'] }} cm</td><td class="px-2 py-3">{{ $measurement['hips'] }} cm</td><td class="px-2 py-3">{{ $measurement['length'] }} cm</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <p class="mt-4 text-xs leading-5 text-muted">{{ $product['material'] }}. Sai số thủ công cho phép ±1 cm.</p>
                        </div>
                    </section>

                    <section x-data="{ open: false }" class="border-b border-line">
                        <button type="button" class="flex min-h-16 w-full items-center justify-between gap-4 py-4 text-left" :aria-expanded="open" aria-controls="escrow-content" @click="open = !open">
                            <span class="text-xs font-semibold uppercase tracking-[0.12em]">Quy trình hoàn cọc tự động</span>
                            <svg aria-hidden="true" class="size-4 transition-transform motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <div id="escrow-content" x-show="open" x-transition.opacity.duration.150ms class="pb-6 text-sm leading-7 text-muted">
                            <ol class="space-y-3">
                                <li class="grid grid-cols-[2rem_1fr] gap-2"><span class="font-display text-lg text-ink">01</span><p>Khoản cọc được cổng VNPAY/MoMo đóng băng riêng, Shop không thể rút trong thời gian thuê.</p></li>
                                <li class="grid grid-cols-[2rem_1fr] gap-2"><span class="font-display text-lg text-ink">02</span><p>Sau khi nhận đồ trả, Shop kiểm định tình trạng và tải biên bản đối soát trong tối đa 24 giờ.</p></li>
                                <li class="grid grid-cols-[2rem_1fr] gap-2"><span class="font-display text-lg text-ink">03</span><p>Nếu không có phát sinh, lệnh hoàn cọc tự động được gửi về phương thức thanh toán ban đầu.</p></li>
                            </ol>
                        </div>
                    </section>

                    <section x-data="{ open: false }" class="border-b border-line">
                        <button type="button" class="flex min-h-16 w-full items-center justify-between gap-4 py-4 text-left" :aria-expanded="open" aria-controls="sanitation-content" @click="open = !open">
                            <span class="text-xs font-semibold uppercase tracking-[0.12em]">Giặt hấp &amp; khử khuẩn</span>
                            <svg aria-hidden="true" class="size-4 transition-transform motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <div id="sanitation-content" x-show="open" x-transition.opacity.duration.150ms class="pb-6 text-sm leading-7 text-muted">
                            <p>Mỗi thiết kế đi qua quy trình bốn bước: kiểm tra sợi vải, giặt hấp dung môi dịu nhẹ, khử khuẩn hơi nước nhiệt độ phù hợp và niêm phong trong túi bảo quản mới. Chu trình được ghi nhận theo mã SKU để truy xuất trước mỗi lượt thuê.</p>
                        </div>
                    </section>
                </div>
            </section>
        </div>

        <template x-teleport="body">
            <div
                x-show="sizeModalOpen"
                x-cloak
                class="fixed inset-0 z-[100]"
                @keydown.escape.window="if (sizeModalOpen) closeSizeModal()"
            >
                <div
                    x-show="sizeModalOpen"
                    x-transition.opacity.duration.200ms
                    class="absolute inset-0 bg-ink/65"
                    aria-hidden="true"
                    @click="closeSizeModal()"
                ></div>

                <section
                    x-show="sizeModalOpen"
                    x-trap.noscroll="sizeModalOpen"
                    x-transition:enter="transition ease-out duration-300 motion-reduce:transition-none"
                    x-transition:enter-start="translate-y-4 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="translate-y-3 opacity-0"
                    class="absolute inset-x-0 bottom-0 max-h-[92svh] overflow-y-auto bg-paper px-5 py-7 sm:bottom-auto sm:left-1/2 sm:top-1/2 sm:w-[min(100%-2rem,32rem)] sm:-translate-x-1/2 sm:-translate-y-1/2 sm:px-8 sm:py-8"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="size-advisor-title"
                >
                    <header class="flex items-start justify-between gap-6 border-b border-line pb-5">
                        <div>
                            <p class="eyebrow text-muted">AI Stylist · Size Match</p>
                            <h2 id="size-advisor-title" class="mt-2 text-3xl">Tư vấn kích cỡ</h2>
                        </div>
                        <button type="button" class="-mr-2 flex size-11 shrink-0 items-center justify-center" aria-label="Đóng cửa sổ tư vấn size" @click="closeSizeModal()">
                            <svg aria-hidden="true" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M5 5l14 14M19 5 5 19" /></svg>
                        </button>
                    </header>

                    <form class="mt-6" @submit.prevent="recommendSize()">
                        <p class="text-sm leading-6 text-muted">Nhập hai thông số cơ bản để hệ thống đối chiếu với bảng số đo thực tế của thiết kế.</p>
                        <div class="mt-6 grid gap-5 sm:grid-cols-2">
                            <label class="block text-xs font-medium uppercase tracking-[0.1em]">
                                Chiều cao (cm)
                                <input
                                    x-ref="heightInput"
                                    x-model.number="height"
                                    type="number"
                                    min="130"
                                    max="210"
                                    required
                                    inputmode="decimal"
                                    class="mt-2 min-h-12 w-full rounded-none border border-line bg-paper px-3 text-base normal-case tracking-normal focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink"
                                >
                            </label>
                            <label class="block text-xs font-medium uppercase tracking-[0.1em]">
                                Cân nặng (kg)
                                <input
                                    x-model.number="weight"
                                    type="number"
                                    min="35"
                                    max="150"
                                    required
                                    inputmode="decimal"
                                    class="mt-2 min-h-12 w-full rounded-none border border-line bg-paper px-3 text-base normal-case tracking-normal focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink"
                                >
                            </label>
                        </div>

                        <div x-show="recommendedSize" class="mt-6 border-y border-line py-5" role="status" aria-live="polite">
                            <p class="text-xs text-muted">Kích cỡ đề xuất cho thiết kế này</p>
                            <p class="mt-1 font-display text-4xl" x-text="recommendedSize"></p>
                            <p class="mt-2 text-xs leading-5 text-muted">Đề xuất là tham khảo. Hãy đối chiếu thêm số đo ba vòng trong bảng thông số bên dưới.</p>
                        </div>

                        <div class="mt-7 grid gap-3 sm:grid-cols-2">
                            <button type="submit" class="button-primary w-full">Phân tích kích cỡ</button>
                            <button type="button" class="button-secondary w-full" x-show="recommendedSize" @click="applyRecommendedSize()">Chọn size này</button>
                        </div>
                    </form>
                </section>
            </div>
        </template>
    </article>
@endsection

@push('scripts')
    <script>
        window.productDetail = function (config) {
            return {
                product: config.product,
                sizes: config.sizes,
                unavailableDates: config.unavailableDates,
                activeTab: 'rental',
                liked: false,
                rentalStart: '',
                rentalEnd: '',
                rentalSize: '',
                purchaseSize: '',
                calendarCursor: null,
                sizeModalOpen: false,
                height: null,
                weight: null,
                recommendedSize: '',
                lastFocusedElement: null,

                init() {
                    const today = this.localDate(new Date());
                    this.calendarCursor = new Date(today.getFullYear(), today.getMonth(), 1);
                },

                localDate(date) {
                    return new Date(date.getFullYear(), date.getMonth(), date.getDate(), 12);
                },

                isoDate(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');

                    return year + '-' + month + '-' + day;
                },

                parseDate(iso) {
                    return new Date(iso + 'T12:00:00');
                },

                get todayIso() {
                    return this.isoDate(this.localDate(new Date()));
                },

                get canMovePrevious() {
                    if (!this.calendarCursor) {
                        return false;
                    }

                    const today = new Date();
                    const currentMonth = new Date(today.getFullYear(), today.getMonth(), 1);

                    return this.calendarCursor > currentMonth;
                },

                moveCalendar(direction) {
                    if (direction < 0 && !this.canMovePrevious) {
                        return;
                    }

                    this.calendarCursor = new Date(
                        this.calendarCursor.getFullYear(),
                        this.calendarCursor.getMonth() + direction,
                        1,
                    );
                },

                monthDate(offset) {
                    return new Date(
                        this.calendarCursor.getFullYear(),
                        this.calendarCursor.getMonth() + offset,
                        1,
                    );
                },

                monthLabel(offset) {
                    return new Intl.DateTimeFormat('vi-VN', {
                        month: 'long',
                        year: 'numeric',
                    }).format(this.monthDate(offset));
                },

                monthDays(offset) {
                    const month = this.monthDate(offset);
                    const year = month.getFullYear();
                    const monthIndex = month.getMonth();
                    const leadingDays = (month.getDay() + 6) % 7;
                    const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();
                    const cells = [];

                    for (let index = 0; index < 42; index += 1) {
                        const dayNumber = index - leadingDays + 1;

                        if (dayNumber < 1 || dayNumber > daysInMonth) {
                            cells.push({
                                key: 'blank-' + offset + '-' + index,
                                blank: true,
                            });

                            continue;
                        }

                        const date = new Date(year, monthIndex, dayNumber, 12);
                        const iso = this.isoDate(date);
                        const unavailable = this.unavailableDates.includes(iso);

                        cells.push({
                            key: iso,
                            blank: false,
                            day: dayNumber,
                            iso: iso,
                            unavailable: unavailable,
                            disabled: iso < this.todayIso || unavailable,
                            label: new Intl.DateTimeFormat('vi-VN', {
                                weekday: 'long',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                            }).format(date),
                        });
                    }

                    return cells;
                },

                selectDate(iso) {
                    if (iso < this.todayIso || this.unavailableDates.includes(iso)) {
                        return;
                    }

                    if (this.rentalStart === '' || this.rentalEnd !== '' || iso < this.rentalStart) {
                        this.rentalStart = iso;
                        this.rentalEnd = '';

                        return;
                    }

                    const rangeContainsUnavailableDate = this.unavailableDates.some(
                        (date) => date >= this.rentalStart && date <= iso,
                    );

                    if (rangeContainsUnavailableDate) {
                        this.rentalStart = iso;
                        this.rentalEnd = '';

                        return;
                    }

                    this.rentalEnd = iso;
                },

                clearDates() {
                    this.rentalStart = '';
                    this.rentalEnd = '';
                },

                isBoundary(iso) {
                    return iso === this.rentalStart || iso === this.rentalEnd;
                },

                isInRange(iso) {
                    return this.rentalStart !== ''
                        && this.rentalEnd !== ''
                        && iso > this.rentalStart
                        && iso < this.rentalEnd;
                },

                get rentalDays() {
                    if (this.rentalStart === '' || this.rentalEnd === '') {
                        return 0;
                    }

                    const millisecondsPerDay = 86400000;

                    return Math.round((this.parseDate(this.rentalEnd) - this.parseDate(this.rentalStart)) / millisecondsPerDay) + 1;
                },

                get rentalTotal() {
                    return this.rentalDays * this.product.rentalPrice;
                },

                get rentalReady() {
                    return this.rentalDays > 0 && this.rentalSize !== '';
                },

                get rentalSummary() {
                    if (this.rentalStart === '') {
                        return 'Chọn ngày nhận trên lịch để bắt đầu.';
                    }

                    if (this.rentalEnd === '') {
                        return 'Đã chọn ngày nhận ' + this.formatDate(this.rentalStart) + '. Hãy chọn ngày trả.';
                    }

                    return 'Lịch thuê: ' + this.formatDate(this.rentalStart) + ' — ' + this.formatDate(this.rentalEnd) + '.';
                },

                formatDate(iso) {
                    return new Intl.DateTimeFormat('vi-VN').format(this.parseDate(iso));
                },

                formatCurrency(value) {
                    return new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',
                        maximumFractionDigits: 0,
                    }).format(value);
                },

                addRentalToCart() {
                    if (!this.rentalReady) {
                        return;
                    }

                    this.$store.cart.addRental(this.product, {
                        startDate: this.rentalStart,
                        endDate: this.rentalEnd,
                        size: this.rentalSize,
                    });
                    this.$dispatch('cart-drawer-open');
                },

                addPurchaseToCart() {
                    if (this.purchaseSize === '') {
                        return;
                    }

                    this.$store.cart.addPurchase(this.product, this.purchaseSize);
                    this.$dispatch('cart-drawer-open');
                },

                openSizeModal() {
                    this.lastFocusedElement = document.activeElement;
                    this.recommendedSize = '';
                    this.sizeModalOpen = true;
                    this.$nextTick(() => this.$refs.heightInput?.focus());
                },

                closeSizeModal() {
                    this.sizeModalOpen = false;
                    this.$nextTick(() => this.lastFocusedElement?.focus());
                },

                recommendSize() {
                    if (!this.height || !this.weight) {
                        return;
                    }

                    let suggested = 'XL';

                    if (this.height <= 158 && this.weight <= 50) {
                        suggested = 'XS';
                    } else if (this.height <= 165 && this.weight <= 58) {
                        suggested = 'S';
                    } else if (this.height <= 173 && this.weight <= 69) {
                        suggested = 'M';
                    } else if (this.height <= 182 && this.weight <= 82) {
                        suggested = 'L';
                    }

                    const orderedSizes = ['XS', 'S', 'M', 'L', 'XL'];
                    const targetIndex = orderedSizes.indexOf(suggested);
                    this.recommendedSize = this.sizes.reduce((closest, size) => {
                        if (closest === '') {
                            return size;
                        }

                        return Math.abs(orderedSizes.indexOf(size) - targetIndex)
                            < Math.abs(orderedSizes.indexOf(closest) - targetIndex)
                            ? size
                            : closest;
                    }, '');
                },

                applyRecommendedSize() {
                    if (this.recommendedSize === '') {
                        return;
                    }

                    if (this.activeTab === 'rental') {
                        this.rentalSize = this.recommendedSize;
                    } else {
                        this.purchaseSize = this.recommendedSize;
                    }

                    this.closeSizeModal();
                },
            };
        };
    </script>
@endpush
