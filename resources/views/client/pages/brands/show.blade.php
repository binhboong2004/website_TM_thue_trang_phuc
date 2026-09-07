@extends('client.layouts.app')

@php
    $brandSlug = request()->route('brand');
    $brandNames = [
        'saint-laurent' => 'Saint Laurent',
        'dior' => 'Dior',
        'prada' => 'Prada',
        'alexander-mcqueen' => 'Alexander McQueen',
        'cong-tri' => 'Công Trí',
        'lam-gia-khang' => 'Lâm Gia Khang',
        'do-manh-cuong' => 'Đỗ Mạnh Cường',
        'maison-elan' => 'Maison Élan',
    ];
    $brandName = $brandNames[$brandSlug] ?? str($brandSlug)->replace('-', ' ')->title()->toString();
@endphp

@section('title', $brandName.' | Thương hiệu | LUXE ROTATE')
@section('meta_description', 'Khám phá tuyển chọn thiết kế '.$brandName.' để thuê theo lịch hoặc mua đứt tại LUXE ROTATE.')
@section('canonical', route('client.brands.show', $brandSlug))

@section('content')
    <section class="border-b border-line bg-ink text-paper">
        <div class="shell py-20 sm:py-28">
            <nav aria-label="Điều hướng phân cấp" class="text-[10px] font-semibold uppercase tracking-[0.16em] text-white/60">
                <a href="{{ route('client.brands') }}" class="hover:text-paper">Thương hiệu</a>
                <span class="mx-2">/</span>
                <span aria-current="page">{{ $brandName }}</span>
            </nav>
            <p class="eyebrow mt-12 text-white/55">Designer profile</p>
            <h1 class="mt-4 font-display text-6xl sm:text-7xl lg:text-8xl">{{ $brandName }}</h1>
            <p class="mt-7 max-w-2xl text-sm leading-7 text-white/65">Tuyển chọn thiết kế nổi bật với thông tin thuê, mua và lịch khả dụng minh bạch.</p>
            <a href="{{ route('client.shop', ['brands' => [$brandName]]) }}" class="button-light mt-9">Xem thiết kế</a>
        </div>
    </section>
@endsection
