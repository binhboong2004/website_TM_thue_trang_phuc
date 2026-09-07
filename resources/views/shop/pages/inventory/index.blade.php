@extends('shop.layouts.app')

@section('title', 'Kho món đồ vật lý')

@section('page_header')
    <p class="eyebrow text-muted">Inventory intelligence</p>
    <div class="mt-3 flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <h1 class="text-3xl tracking-tight sm:text-4xl">Kho món đồ vật lý</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-muted">Quản lý từng Garment Item có SKU và mã QR riêng, độc lập với thông tin chung của Product Template.</p>
        </div>
        <button type="button" class="button-primary self-start">
            <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12h14" /></svg>
            Thêm món đồ vật lý
        </button>
    </div>
@endsection

@section('content')
    <div x-data="inventoryWorkspace(@js($templates))">
        <section aria-labelledby="inventory-metrics-title">
            <h2 id="inventory-metrics-title" class="sr-only">Chỉ số kho</h2>
            <dl class="grid gap-px border border-line bg-line sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($metrics as $metric)
                    <div class="bg-paper p-5 sm:p-6">
                        <dt class="text-xs text-muted">{{ $metric['label'] }}</dt>
                        <dd class="mt-5 text-3xl font-semibold tabular-nums">{{ $metric['value'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>

        <section class="mt-8 border border-line bg-paper" aria-labelledby="inventory-architecture-title">
            <div class="grid lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
                <div class="border-b border-line p-6 lg:border-b-0 lg:border-r">
                    <p class="eyebrow text-muted">Kiến trúc dữ liệu</p>
                    <h2 id="inventory-architecture-title" class="mt-2 text-2xl">Một mẫu, nhiều món đồ thật</h2>
                    <p class="mt-3 text-sm leading-6 text-muted">Chỉnh sửa tên, nội dung hay giá trên Mẫu thiết kế không làm thay đổi danh tính, lịch thuê hoặc lịch sử tình trạng của từng món đồ vật lý.</p>
                </div>
                <div class="grid gap-px bg-line sm:grid-cols-2">
                    <article class="bg-canvas p-6">
                        <span class="flex size-9 items-center justify-center border border-ink text-xs font-semibold">01</span>
                        <h3 class="mt-4 font-sans text-sm font-semibold">Product Template · Mẫu thiết kế</h3>
                        <p class="mt-2 text-xs leading-5 text-muted">Tên, thương hiệu, mô tả, ảnh, giá thuê và giá mua dùng chung.</p>
                    </article>
                    <article class="bg-paper p-6">
                        <span class="flex size-9 items-center justify-center bg-ink text-xs font-semibold text-paper">N</span>
                        <h3 class="mt-4 font-sans text-sm font-semibold">Garment Item · Món đồ vật lý</h3>
                        <p class="mt-2 text-xs leading-5 text-muted">SKU, QR, size, tình trạng và lịch khả dụng riêng cho từng chiếc.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="mt-8" aria-labelledby="availability-title">
            <div class="flex flex-col gap-5 border-b border-line pb-6 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <p class="eyebrow text-muted">14 ngày tiếp theo</p>
                    <h2 id="availability-title" class="mt-2 text-2xl">Lịch khả dụng & thời gian đệm</h2>
                </div>
                <div class="flex flex-wrap gap-x-5 gap-y-3 text-[11px] font-medium">
                    <span class="inline-flex items-center gap-2"><i class="size-3 border border-neutral-300 bg-paper" aria-hidden="true"></i>Sẵn sàng</span>
                    <span class="inline-flex items-center gap-2"><i class="size-3 bg-ink" aria-hidden="true"></i>Đang cho thuê</span>
                    <span class="inline-flex items-center gap-2"><i class="size-3 border border-neutral-400 bg-neutral-200" aria-hidden="true"></i>Đệm giặt hấp</span>
                    <span class="inline-flex items-center gap-2"><i class="size-3 border border-ink bg-paper" aria-hidden="true"></i>Bảo dưỡng</span>
                </div>
            </div>

            <div class="mt-6 grid gap-3 md:grid-cols-[minmax(0,1fr)_13rem]">
                <label class="relative">
                    <span class="sr-only">Tìm theo mẫu thiết kế, SKU hoặc mã QR</span>
                    <svg aria-hidden="true" class="absolute left-4 top-1/2 size-4 -translate-y-1/2 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7" /><path d="m16 16 4 4" /></svg>
                    <input x-model.debounce.200ms="query" type="search" class="min-h-12 w-full rounded-none border border-line bg-paper pl-11 pr-4 text-sm placeholder:text-muted focus:border-ink focus:outline-none" placeholder="Tìm mẫu, SKU hoặc mã QR...">
                </label>
                <label>
                    <span class="sr-only">Lọc trạng thái</span>
                    <select x-model="status" class="min-h-12 w-full rounded-none border border-line bg-paper px-4 text-sm focus:border-ink focus:outline-none">
                        <option value="all">Mọi trạng thái</option>
                        <option value="available">Sẵn sàng</option>
                        <option value="rented">Đang cho thuê</option>
                        <option value="buffer">Đệm bảo dưỡng</option>
                        <option value="maintenance">Bảo dưỡng</option>
                    </select>
                </label>
            </div>

            <p class="mt-6 border border-line bg-paper px-5 py-4 text-sm" x-show="!hasMatches" x-cloak>Không tìm thấy món đồ phù hợp với bộ lọc.</p>

            <div class="mt-6 space-y-6">
                @foreach ($templates as $templateIndex => $template)
                    <article
                        class="overflow-hidden border border-line bg-paper"
                        x-show="matches(templates[{{ $templateIndex }}])"
                        x-transition.opacity
                    >
                        <header class="grid gap-5 border-b border-line p-5 md:grid-cols-[5rem_1fr_auto] md:items-center">
                            <img src="{{ $template['image'] }}" alt="" class="aspect-[3/4] w-20 bg-fog object-cover" width="160" height="214">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="border border-line px-2 py-1 text-[9px] font-semibold uppercase tracking-[0.14em] text-muted">Mẫu thiết kế</span>
                                    <span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">{{ $template['code'] }}</span>
                                </div>
                                <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.15em] text-muted">{{ $template['brand'] }}</p>
                                <h3 class="mt-1 font-display text-2xl">{{ $template['name'] }}</h3>
                            </div>
                            <div class="md:text-right">
                                <p class="text-2xl font-semibold tabular-nums">{{ count($template['items']) }}</p>
                                <p class="text-xs text-muted">món đồ vật lý</p>
                            </div>
                        </header>

                        <div class="overflow-x-auto" role="region" aria-label="Lịch 14 ngày của {{ $template['name'] }}" tabindex="0">
                            <div class="min-w-[64rem]">
                                <div class="grid border-b border-line bg-fog" style="grid-template-columns: 18rem repeat({{ count($timeline) }}, minmax(3.25rem, 1fr));">
                                    <div class="border-r border-line px-5 py-3 text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Garment Item / QR</div>
                                    @foreach ($timeline as $day)
                                        <div class="border-r border-line px-1 py-2 text-center last:border-r-0 {{ $day['is_today'] ? 'bg-ink text-paper' : '' }}">
                                            <p class="text-[9px] font-semibold uppercase">{{ $day['day'] }}</p>
                                            <p class="mt-1 text-[10px] tabular-nums">{{ $day['date'] }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                @foreach ($template['items'] as $item)
                                    <div
                                        class="grid min-h-24 border-b border-line last:border-b-0"
                                        style="grid-template-columns: 18rem minmax(0, 1fr);"
                                        x-show="itemMatches(@js($template), @js($item))"
                                    >
                                        <div class="flex items-center gap-3 border-r border-line px-4 py-3">
                                            <svg aria-hidden="true" class="size-10 shrink-0 border border-line bg-paper p-1" viewBox="0 0 28 28" fill="currentColor">
                                                <path d="M2 2h8v8H2V2Zm2 2v4h4V4H4Zm14-2h8v8h-8V2Zm2 2v4h4V4h-4ZM2 18h8v8H2v-8Zm2 2v4h4v-4H4Zm9-18h3v3h-3V2Zm0 5h3v5h-3V7Zm5 6h3v3h-3v-3Zm5 0h3v5h-3v-5Zm-12 2h4v3h-4v-3Zm5 4h4v3h-4v-3Zm6 2h4v5h-4v-5Zm-10 2h5v3h-5v-3Z" />
                                            </svg>
                                            <div class="min-w-0">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <p class="text-xs font-semibold">{{ $item['code'] }}</p>
                                                    <span class="border border-line px-1.5 py-0.5 text-[9px] font-semibold">SIZE {{ $item['size'] }}</span>
                                                </div>
                                                <p class="mt-1 truncate text-[10px] text-muted">{{ $item['qr'] }}</p>
                                                <p class="mt-1 text-[10px] font-medium">{{ $item['status_label'] }} · {{ $item['condition'] }}</p>
                                            </div>
                                        </div>

                                        <div class="relative grid items-center" style="grid-template-columns: repeat({{ count($timeline) }}, minmax(3.25rem, 1fr));">
                                            @foreach ($timeline as $day)
                                                <div class="h-full border-r border-line last:border-r-0 {{ $day['is_today'] ? 'bg-neutral-100' : '' }}" aria-hidden="true"></div>
                                            @endforeach

                                            @foreach ($item['schedule'] as $block)
                                                @php
                                                    $blockClass = match ($block['type']) {
                                                        'rented' => 'bg-ink text-paper',
                                                        'buffer' => 'border border-neutral-400 bg-neutral-200 text-ink',
                                                        'maintenance' => 'border border-ink bg-paper text-ink',
                                                    };
                                                @endphp
                                                <div
                                                    class="z-10 mx-1 flex min-h-10 items-center justify-center overflow-hidden px-2 text-center text-[9px] font-semibold uppercase tracking-[0.08em] {{ $blockClass }}"
                                                    style="grid-column: {{ $block['start'] + 1 }} / span {{ $block['span'] }}; grid-row: 1;"
                                                    title="{{ $block['label'] }}"
                                                >
                                                    <span class="truncate">{{ $block['label'] }}</span>
                                                </div>
                                            @endforeach

                                            @if (empty($item['schedule']))
                                                <p class="pointer-events-none z-10 col-span-full row-start-1 px-4 text-xs text-muted">Trống toàn kỳ · Có thể nhận lịch thuê</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        window.inventoryWorkspace = function (templates) {
            return {
                templates,
                query: '',
                status: 'all',

                normalize(value) {
                    return String(value ?? '').toLocaleLowerCase('vi');
                },

                itemMatches(template, item) {
                    const searchText = this.normalize([
                        template.name,
                        template.brand,
                        template.code,
                        item.code,
                        item.qr,
                        item.size,
                    ].join(' '));
                    const matchesQuery = this.query.trim() === '' || searchText.includes(this.normalize(this.query.trim()));
                    const matchesStatus = this.status === 'all' || item.status === this.status;

                    return matchesQuery && matchesStatus;
                },

                matches(template) {
                    return template.items.some((item) => this.itemMatches(template, item));
                },

                get hasMatches() {
                    return this.templates.some((template) => this.matches(template));
                },
            };
        };
    </script>
@endpush
