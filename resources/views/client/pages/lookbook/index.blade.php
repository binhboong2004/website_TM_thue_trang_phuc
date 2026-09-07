@extends('client.layouts.app')

@section('title', 'LOOKBOOK | Cộng đồng thời trang | LUXE ROTATE')
@section('meta_description', 'Khám phá Lookbook cộng đồng và thuê ngay những thiết kế xuất hiện trong từng khung hình qua shoppable tags.')
@section('canonical', route('client.lookbook'))
@section('og_type', 'website')
@section('og_image', asset('images/editorial/city-lookbook.webp'))
@section('og_image_alt', 'Cộng đồng LUXE ROTATE mặc thời trang thiết kế trong đời sống thật')

@push('structured-data')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ImageGallery',
        'name' => 'LOOKBOOK cộng đồng LUXE ROTATE',
        'url' => route('client.lookbook'),
        'description' => 'Lấy cảm hứng từ cộng đồng và khám phá các thiết kế có thể thuê trong từng khung hình.',
        'image' => collect($looks)->map(fn (array $look): array => [
            '@type' => 'ImageObject',
            'contentUrl' => $look['image'],
            'caption' => $look['caption'],
            'creator' => [
                '@type' => 'Person',
                'name' => $look['author'],
            ],
        ])->all(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    <div x-data="{ activeLook: null }" @keydown.escape.window="activeLook = null">
        <section class="border-b border-line bg-paper">
            <div class="shell py-14 sm:py-20 lg:py-24">
                <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-end">
                    <div>
                        <p class="eyebrow text-muted">Community editorial · #LuxeInRotation</p>
                        <h1 class="mt-5 font-display text-[clamp(4rem,11vw,9rem)] leading-[0.82] tracking-[-0.045em]">LOOKBOOK</h1>
                    </div>

                    <div class="lg:pb-2">
                        <p class="max-w-md text-base leading-7 text-ink sm:text-lg sm:leading-8">
                            Lấy cảm hứng từ cộng đồng. Chọn Thuê ngay những thiết kế xuất hiện trong khung hình.
                        </p>

                        @auth
                            <a
                                href="mailto:lookbook@luxerotate.vn?subject={{ rawurlencode('Chia sẻ phong cách cùng LUXE ROTATE') }}"
                                class="button-primary mt-7 w-full sm:w-auto"
                            >
                                Chia sẻ phong cách của bạn
                                <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 16V4m0 0L7.5 8.5M12 4l4.5 4.5M5 13v7h14v-7" />
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="mt-12 flex flex-wrap items-center justify-between gap-4 border-t border-line pt-5 text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">
                    <p>{{ count($looks) }} câu chuyện cộng đồng</p>
                    <p class="flex items-center gap-2">
                        <span aria-hidden="true" class="relative flex size-3 items-center justify-center">
                            <span class="absolute size-3 animate-ping rounded-full bg-ink/25 motion-reduce:animate-none"></span>
                            <span class="relative size-1.5 rounded-full bg-ink"></span>
                        </span>
                        Chạm vào điểm đánh dấu để khám phá thiết kế
                    </p>
                </div>
            </div>
        </section>

        <section id="lookbook-gallery" class="shell py-10 sm:py-14 lg:py-16" aria-labelledby="lookbook-gallery-title">
            <h2 id="lookbook-gallery-title" class="sr-only">Ảnh Lookbook cộng đồng có thể mua sắm</h2>

            <div class="columns-2 gap-3 md:columns-3 md:gap-5 lg:columns-4">
                @foreach ($looks as $look)
                    <article class="mb-8 break-inside-avoid sm:mb-12" aria-labelledby="look-title-{{ $look['id'] }}">
                        <figure
                            class="group relative z-0 bg-fog focus-within:z-30 hover:z-30"
                            x-data="{ open: false }"
                            @mouseleave="open = false; if (activeLook === '{{ $look['id'] }}') activeLook = null"
                            @focusout="if (!$el.contains($event.relatedTarget)) { open = false; if (activeLook === '{{ $look['id'] }}') activeLook = null }"
                        >
                            <div class="relative overflow-hidden" style="aspect-ratio: {{ $look['aspect'] }};">
                                <img
                                    src="{{ $look['image'] }}"
                                    alt="{{ $look['caption'] }} — phong cách của {{ $look['author'] }}"
                                    class="size-full object-cover transition-transform duration-700 ease-[var(--ease-editorial)] motion-reduce:transition-none group-hover:scale-[1.02]"
                                    style="object-position: {{ $look['position'] }};"
                                    width="900"
                                    height="1200"
                                    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                    decoding="async"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent opacity-70" aria-hidden="true"></div>
                            </div>

                            <div
                                class="absolute z-20 size-11"
                                style="left: calc({{ $look['hotspot']['x'] }}% - 1.375rem); top: calc({{ $look['hotspot']['y'] }}% - 1.375rem);"
                            >
                                <button
                                    type="button"
                                    class="relative flex size-11 touch-manipulation items-center justify-center rounded-full text-white focus-visible:outline-white"
                                    aria-label="Xem {{ $look['product']['name'] }} trong ảnh"
                                    aria-haspopup="dialog"
                                    aria-controls="look-product-{{ $look['id'] }}"
                                    :aria-expanded="open"
                                    @mouseenter="open = true; activeLook = '{{ $look['id'] }}'"
                                    @focus="open = true; activeLook = '{{ $look['id'] }}'"
                                    @click.stop="open = true; activeLook = '{{ $look['id'] }}'"
                                >
                                    <span class="absolute size-5 animate-ping rounded-full bg-white/50 motion-reduce:animate-none" aria-hidden="true"></span>
                                    <span class="relative flex size-4 items-center justify-center rounded-full border border-black/20 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.28)]" aria-hidden="true">
                                        <span class="size-1.5 rounded-full bg-ink"></span>
                                    </span>
                                </button>

                                <div
                                    id="look-product-{{ $look['id'] }}"
                                    x-show="open && activeLook === '{{ $look['id'] }}'"
                                    x-cloak
                                    @click.outside="open = false; if (activeLook === '{{ $look['id'] }}') activeLook = null"
                                    x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    role="dialog"
                                    aria-label="Thông tin thiết kế {{ $look['product']['name'] }}"
                                    @class([
                                        'fixed inset-x-4 bottom-4 z-[80] w-auto border border-line bg-paper p-4 text-ink shadow-[0_12px_40px_rgba(0,0,0,0.18)] sm:absolute sm:inset-x-auto sm:bottom-auto sm:top-11 sm:z-30 sm:w-60 sm:p-5',
                                        'sm:left-0' => $look['hotspot']['popoverSide'] === 'right',
                                        'sm:right-0' => $look['hotspot']['popoverSide'] === 'left',
                                    ])
                                >
                                    <button
                                        type="button"
                                        class="absolute right-1 top-1 flex size-11 items-center justify-center"
                                        aria-label="Đóng thông tin thiết kế"
                                        @click.stop="open = false; activeLook = null"
                                    >
                                        <svg aria-hidden="true" class="size-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3"><path d="m5 5 10 10M15 5 5 15" /></svg>
                                    </button>
                                    <p class="pr-8 text-[9px] font-semibold uppercase tracking-[0.18em] text-muted">{{ $look['product']['brand'] }}</p>
                                    <h3 class="mt-2 font-display text-lg leading-snug">{{ $look['product']['name'] }}</h3>
                                    <p class="mt-3 border-t border-line pt-3 text-xs font-semibold tabular-nums">
                                        {{ number_format($look['product']['rentalPrice'], 0, ',', '.') }}đ <span class="font-normal text-muted">/ ngày</span>
                                    </p>
                                    <a href="{{ $look['product']['url'] }}" class="mt-4 flex min-h-11 w-full items-center justify-between bg-ink px-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-paper">
                                        Thuê ngay
                                        <svg aria-hidden="true" class="size-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M2 8h12M9.5 3.5 14 8l-4.5 4.5" /></svg>
                                    </a>
                                </div>
                            </div>
                        </figure>

                        <div class="mt-4 border-t border-line pt-4 sm:mt-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-muted sm:text-[10px]">{{ $look['occasion'] }}</p>
                                    <h3 id="look-title-{{ $look['id'] }}" class="mt-1 truncate font-sans text-xs font-semibold sm:text-sm">{{ '@'.$look['author'] }}</h3>
                                </div>

                                <button
                                    type="button"
                                    class="flex min-h-11 shrink-0 items-center gap-1.5 px-1 text-xs tabular-nums"
                                    x-data="{ liked: false, count: {{ $look['likes'] }} }"
                                    :aria-pressed="liked"
                                    :aria-label="liked ? 'Bỏ thích bài viết của {{ $look['author'] }}' : 'Thích bài viết của {{ $look['author'] }}'"
                                    @click="liked = !liked; count += liked ? 1 : -1"
                                >
                                    <svg aria-hidden="true" class="size-4 transition-transform duration-150 motion-reduce:transition-none" :class="liked && 'scale-110'" viewBox="0 0 24 24" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="1.2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z" /></svg>
                                    <span x-text="count">{{ $look['likes'] }}</span>
                                </button>
                            </div>
                            <p class="mt-2 text-xs leading-5 text-muted sm:text-sm sm:leading-6">{{ $look['caption'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
@endsection