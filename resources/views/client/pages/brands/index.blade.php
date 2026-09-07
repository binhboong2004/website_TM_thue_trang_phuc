@extends('client.layouts.app')

@section('title', 'Thương hiệu thời trang thiết kế | LUXE ROTATE')
@section('meta_description', 'Khám phá danh mục nhà mốt quốc tế và các nhà thiết kế Việt Nam được tuyển chọn tại LUXE ROTATE.')
@section('canonical', route('client.brands'))
@section('og_image_alt', 'Danh mục thương hiệu thời trang cao cấp LUXE ROTATE')

@php
    $brandGroups = [
        'Nhà mốt quốc tế' => [
            ['name' => 'Saint Laurent', 'slug' => 'saint-laurent', 'origin' => 'Paris, France'],
            ['name' => 'Dior', 'slug' => 'dior', 'origin' => 'Paris, France'],
            ['name' => 'Prada', 'slug' => 'prada', 'origin' => 'Milan, Italy'],
            ['name' => 'Alexander McQueen', 'slug' => 'alexander-mcqueen', 'origin' => 'London, England'],
        ],
        'Thiết kế Việt Nam' => [
            ['name' => 'Công Trí', 'slug' => 'cong-tri', 'origin' => 'TP. Hồ Chí Minh'],
            ['name' => 'Lâm Gia Khang', 'slug' => 'lam-gia-khang', 'origin' => 'TP. Hồ Chí Minh'],
            ['name' => 'Đỗ Mạnh Cường', 'slug' => 'do-manh-cuong', 'origin' => 'TP. Hồ Chí Minh'],
            ['name' => 'Maison Élan', 'slug' => 'maison-elan', 'origin' => 'Hà Nội'],
        ],
    ];
@endphp

@section('content')
    <section class="border-b border-line bg-paper">
        <div class="shell py-14 sm:py-20 lg:py-24">
            <p class="eyebrow text-muted">Designer index · A—Z</p>
            <h1 class="mt-4 max-w-5xl font-display text-5xl leading-[0.95] sm:text-6xl lg:text-7xl">Những tên tuổi định hình tủ đồ đương đại.</h1>
            <p class="mt-6 max-w-2xl text-sm leading-7 text-muted">Từ di sản couture quốc tế đến ngôn ngữ thiết kế Việt Nam mới—mỗi thương hiệu được tuyển chọn dựa trên chất lượng, phom dáng và khả năng lưu chuyển lâu dài.</p>
        </div>
    </section>

    <div class="shell py-12 sm:py-16">
        @foreach ($brandGroups as $group => $brands)
            <section class="border-t border-ink py-8 sm:py-10" aria-labelledby="brand-group-{{ $loop->index }}">
                <div class="grid gap-8 lg:grid-cols-[15rem_1fr]">
                    <div>
                        <p class="eyebrow text-muted">0{{ $loop->iteration }}</p>
                        <h2 id="brand-group-{{ $loop->index }}" class="mt-3 font-display text-2xl">{{ $group }}</h2>
                    </div>
                    <ul class="grid border-t border-line sm:grid-cols-2 sm:border-t-0">
                        @foreach ($brands as $brand)
                            <li class="border-b border-line sm:odd:border-r">
                                <a href="{{ route('client.brands.show', $brand['slug']) }}" class="group flex min-h-28 items-center justify-between gap-6 px-2 py-5 sm:px-6">
                                    <span>
                                        <span class="block font-display text-2xl transition-transform duration-300 motion-reduce:transition-none group-hover:translate-x-1">{{ $brand['name'] }}</span>
                                        <span class="mt-2 block text-[10px] uppercase tracking-[0.14em] text-muted">{{ $brand['origin'] }}</span>
                                    </span>
                                    <svg aria-hidden="true" class="size-5 shrink-0 transition-transform duration-300 motion-reduce:transition-none group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M5 12h14M14 7l5 5-5 5" /></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endforeach
    </div>
@endsection
