@extends('client.layouts.app')

@section('title', 'Mua sắm thời trang cao cấp | LUXE ROTATE')
@section('meta_description', 'Khám phá danh mục thời trang thiết kế cao cấp để thuê theo lịch hoặc mua đứt. Lọc theo size, thương hiệu, khoảng giá và lịch trống.')
@section('canonical', route('client.shop'))
@section('og_image_alt', 'Danh mục thời trang thiết kế cao cấp tại LUXE ROTATE')

@push('structured-data')
    @php
        $catalogSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Danh mục sản phẩm LUXE ROTATE',
            'numberOfItems' => $products->total(),
            'itemListElement' => collect($products->items())->values()->map(fn (array $product, int $index): array => [
                '@type' => 'ListItem',
                'position' => $products->firstItem() + $index,
                'url' => $product['url'],
                'name' => $product['name'],
            ])->all(),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($catalogSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    <section class="border-b border-line bg-paper">
        <div class="shell py-12 sm:py-16 lg:py-20">
            <p class="eyebrow text-muted">Thuê theo lịch · Mua đứt</p>
            <div class="mt-4 grid gap-5 lg:grid-cols-[1fr_auto] lg:items-end">
                <div>
                    <h1 class="max-w-4xl font-display text-4xl leading-tight sm:text-5xl lg:text-6xl">Mua sắm thiết kế cao cấp</h1>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-muted">Một danh mục thống nhất cho những thiết kế bạn muốn mặc trong một dịp hoặc sở hữu lâu dài.</p>
                </div>
                <p class="text-xs uppercase tracking-[0.14em] text-muted" role="status">
                    <span class="font-semibold text-ink tabular-nums">{{ $products->total() }}</span> sản phẩm
                </p>
            </div>
        </div>
    </section>

    <section
        x-data="{ mobileFiltersOpen: false }"
        class="shell py-10 lg:py-14"
        aria-labelledby="catalog-grid-title"
    >
        <button
            type="button"
            class="mb-6 flex min-h-12 w-full items-center justify-between border-y border-line py-3 text-xs font-semibold uppercase tracking-[0.14em] lg:hidden"
            :aria-expanded="mobileFiltersOpen"
            aria-controls="catalog-filters"
            @click="mobileFiltersOpen = !mobileFiltersOpen"
        >
            Bộ lọc
            <svg aria-hidden="true" class="size-4 transition-transform duration-200 motion-reduce:transition-none" :class="mobileFiltersOpen && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
        </button>

        <div class="grid min-w-0 gap-10 lg:grid-cols-[minmax(14rem,0.25fr)_minmax(0,0.75fr)] lg:gap-12 xl:gap-16">
            <aside
                id="catalog-filters"
                :class="mobileFiltersOpen ? 'block' : 'hidden lg:block'"
                class="min-w-0 lg:sticky lg:top-28 lg:self-start"
                aria-label="Bộ lọc sản phẩm"
            >
                <form action="{{ route('client.shop') }}" method="get">
                    <input type="hidden" name="sort" value="{{ $filters['sort'] }}">

                    <div class="border-t border-ink" x-data="{ open: true }">
                        <button type="button" class="flex min-h-14 w-full items-center justify-between py-4 text-left text-xs font-semibold uppercase tracking-[0.13em]" :aria-expanded="open" @click="open = !open">
                            Loại giao dịch
                            <svg aria-hidden="true" class="size-4 transition-transform duration-200 motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <fieldset x-show="open" x-transition.opacity.duration.150ms class="pb-5">
                            <legend class="sr-only">Chọn loại giao dịch</legend>
                            <div class="space-y-1">
                                @foreach (['all' => 'Tất cả', 'rental' => 'Chỉ thuê', 'purchase' => 'Chỉ mua'] as $value => $label)
                                    <label class="flex min-h-11 cursor-pointer items-center gap-3 text-sm">
                                        <input type="radio" name="transaction" value="{{ $value }}" class="size-4 border-neutral-400 text-ink focus:ring-ink" @checked($filters['transaction'] === $value)>
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <div class="border-t border-line" x-data="{ open: true }">
                        <button type="button" class="flex min-h-14 w-full items-center justify-between py-4 text-left text-xs font-semibold uppercase tracking-[0.13em]" :aria-expanded="open" @click="open = !open">
                            Kích cỡ
                            <svg aria-hidden="true" class="size-4 transition-transform duration-200 motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <fieldset x-show="open" x-transition.opacity.duration.150ms class="pb-5">
                            <legend class="sr-only">Chọn kích cỡ</legend>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach ($sizes as $size)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="sizes[]" value="{{ $size }}" class="peer sr-only" @checked(in_array($size, $filters['sizes'], true))>
                                        <span class="flex min-h-11 items-center justify-center border border-line text-xs font-medium peer-checked:border-ink peer-checked:bg-ink peer-checked:text-paper peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-ink">{{ $size }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <div class="border-t border-line" x-data="{ open: false }">
                        <button type="button" class="flex min-h-14 w-full items-center justify-between py-4 text-left text-xs font-semibold uppercase tracking-[0.13em]" :aria-expanded="open" @click="open = !open">
                            Thương hiệu
                            <svg aria-hidden="true" class="size-4 transition-transform duration-200 motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <fieldset x-show="open" x-transition.opacity.duration.150ms class="pb-5">
                            <legend class="sr-only">Chọn thương hiệu</legend>
                            <div class="space-y-1">
                                @foreach ($brands as $brand)
                                    <label class="flex min-h-11 cursor-pointer items-center gap-3 text-sm">
                                        <input type="checkbox" name="brands[]" value="{{ $brand }}" class="size-4 border-neutral-400 text-ink focus:ring-ink" @checked(in_array($brand, $filters['brands'], true))>
                                        <span>{{ $brand }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <div class="border-t border-line" x-data="{ open: false }">
                        <button type="button" class="flex min-h-14 w-full items-center justify-between py-4 text-left text-xs font-semibold uppercase tracking-[0.13em]" :aria-expanded="open" @click="open = !open">
                            Khoảng giá
                            <svg aria-hidden="true" class="size-4 transition-transform duration-200 motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.150ms class="grid grid-cols-2 gap-3 pb-5">
                            <label class="text-xs text-muted">Từ
                                <input type="number" name="min_price" min="0" step="10000" value="{{ $filters['min_price'] }}" placeholder="0₫" class="mt-2 min-h-12 w-full rounded-none border border-line bg-paper px-3 text-base text-ink tabular-nums focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" inputmode="numeric">
                            </label>
                            <label class="text-xs text-muted">Đến
                                <input type="number" name="max_price" min="0" step="10000" value="{{ $filters['max_price'] }}" placeholder="10.000.000₫" class="mt-2 min-h-12 w-full rounded-none border border-line bg-paper px-3 text-base text-ink tabular-nums focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" inputmode="numeric">
                            </label>
                        </div>
                    </div>

                    <div class="border-y border-line" x-data="{ open: false }">
                        <button type="button" class="flex min-h-14 w-full items-center justify-between py-4 text-left text-xs font-semibold uppercase tracking-[0.13em]" :aria-expanded="open" @click="open = !open">
                            Lịch trống
                            <svg aria-hidden="true" class="size-4 transition-transform duration-200 motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m3 6 5 5 5-5" /></svg>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.150ms class="space-y-4 pb-5">
                            <label class="block text-xs text-muted">Từ ngày
                                <input type="date" name="available_from" value="{{ $filters['available_from'] }}" class="mt-2 min-h-12 w-full rounded-none border border-line bg-paper px-3 text-base text-ink focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink">
                            </label>
                            <label class="block text-xs text-muted">Đến ngày
                                <input type="date" name="available_to" value="{{ $filters['available_to'] }}" class="mt-2 min-h-12 w-full rounded-none border border-line bg-paper px-3 text-base text-ink focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink">
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3">
                        <button type="submit" class="button-primary w-full">Áp dụng bộ lọc</button>
                        <a href="{{ route('client.shop') }}" class="button-secondary w-full">Xóa bộ lọc</a>
                    </div>
                </form>
            </aside>

            <div class="min-w-0">
                <header class="flex flex-col gap-4 border-b border-ink pb-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">Danh mục tổng hợp</p>
                        <h2 id="catalog-grid-title" class="mt-2 font-display text-3xl">Thiết kế dành cho bạn</h2>
                    </div>

                    <form action="{{ route('client.shop') }}" method="get" class="flex items-center gap-3 self-start sm:self-auto">
                        <input type="hidden" name="transaction" value="{{ $filters['transaction'] }}">
                        @foreach ($filters['sizes'] as $size)<input type="hidden" name="sizes[]" value="{{ $size }}">@endforeach
                        @foreach ($filters['brands'] as $brand)<input type="hidden" name="brands[]" value="{{ $brand }}">@endforeach
                        @if ($filters['min_price'] !== null)<input type="hidden" name="min_price" value="{{ $filters['min_price'] }}">@endif
                        @if ($filters['max_price'] !== null)<input type="hidden" name="max_price" value="{{ $filters['max_price'] }}">@endif
                        @if ($filters['available_from'] !== null)<input type="hidden" name="available_from" value="{{ $filters['available_from'] }}">@endif
                        @if ($filters['available_to'] !== null)<input type="hidden" name="available_to" value="{{ $filters['available_to'] }}">@endif

                        <label for="catalog-sort" class="whitespace-nowrap text-xs text-muted">Sắp xếp</label>
                        <select id="catalog-sort" name="sort" class="min-h-11 rounded-none border-0 border-b border-ink bg-transparent py-2 pl-0 pr-8 text-sm focus:outline-none focus:ring-0" onchange="this.form.submit()">
                            <option value="newest" @selected($filters['sort'] === 'newest')>Phần mới nhất</option>
                            <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Giá thấp đến cao</option>
                            <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Giá cao đến thấp</option>
                        </select>
                    </form>
                </header>

                @if ($products->isNotEmpty())
                    <div class="mt-8 grid grid-cols-1 gap-x-5 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            <x-client::product-card :product="$item" />
                        @endforeach
                    </div>

                    <div class="mt-14 border-t border-line pt-8">
                        {{ $products->onEachSide(1)->links('client.partials.catalog-pagination') }}
                    </div>
                @else
                    <div class="flex min-h-96 items-center justify-center border-b border-line py-16 text-center">
                        <div class="max-w-md">
                            <h3 class="font-display text-3xl">Không tìm thấy thiết kế phù hợp</h3>
                            <p class="mt-4 text-sm leading-6 text-muted">Hãy mở rộng khoảng giá, chọn thêm kích cỡ hoặc xóa bộ lọc lịch trống.</p>
                            <a href="{{ route('client.shop') }}" class="button-primary mt-7">Xem toàn bộ sản phẩm</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection