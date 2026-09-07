@extends('client.layouts.account')

@section('title', 'Đơn Thuê & Cọc | LUXE ROTATE')
@section('meta_description', 'Theo dõi đơn thuê, lịch nhận trả và tiền cọc Escrow trong tài khoản LUXE ROTATE.')
@section('canonical', url('/account/orders'))
@section('robots', 'noindex, nofollow')

@php
    $orders = [
        [
            'code' => '#ORD-2026',
            'status' => 'Đang xử lý',
            'ordered_at' => '04.09.2026',
            'image' => asset('images/editorial/black-gown.webp'),
            'brand' => 'Maison Élan',
            'name' => 'Noir Sculpted Gown',
            'size' => 'S',
            'rental_period' => '12.09.2026 — 14.09.2026',
            'rental_total' => 1500000,
            'escrow_deposit' => 3000000,
            'detail_url' => route('account.rentals.show', 'ORD-2026'),
        ],
        [
            'code' => '#ORD-2018',
            'status' => 'Đang sử dụng',
            'ordered_at' => '28.08.2026',
            'image' => asset('images/editorial/hero-campaign.webp'),
            'brand' => 'Atelier Blanc',
            'name' => 'Ivory Fluid Suit',
            'size' => 'M',
            'rental_period' => '05.09.2026 — 07.09.2026',
            'rental_total' => 2280000,
            'escrow_deposit' => 4400000,
            'detail_url' => route('account.rentals.show', 'ORD-2018'),
        ],
    ];
@endphp

@section('account_content')
    <header class="mb-10">
        <p class="mb-3 text-[10px] font-medium uppercase tracking-widest text-neutral-500">Rental archive</p>
        <h1 class="font-display text-4xl leading-tight text-black">Đơn thuê & Cọc</h1>
        <p class="mt-4 max-w-2xl text-sm leading-6 text-neutral-600">
            Theo dõi lịch thuê và trạng thái khoản cọc đang được giữ trung gian cho từng đơn hàng.
        </p>
    </header>

    <div aria-label="Danh sách đơn thuê">
        @foreach ($orders as $order)
            <article class="border border-neutral-200 p-6 mb-6">
                <header class="flex flex-col gap-4 border-b border-neutral-200 pb-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                        <h2 class="text-xs font-semibold uppercase tracking-widest text-black">{{ $order['code'] }}</h2>
                        <span class="border border-neutral-300 bg-white px-2.5 py-1 text-[10px] font-medium uppercase tracking-widest text-neutral-700">
                            {{ $order['status'] }}
                        </span>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-neutral-500">
                        Ngày đặt <time datetime="{{ \Carbon\Carbon::createFromFormat('d.m.Y', $order['ordered_at'])->format('Y-m-d') }}">{{ $order['ordered_at'] }}</time>
                    </p>
                </header>

                <div class="flex flex-col gap-5 py-6 sm:flex-row sm:items-center">
                    <a href="{{ $order['detail_url'] }}" class="block w-20 shrink-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-black">
                        <img
                            src="{{ $order['image'] }}"
                            alt="{{ $order['name'] }} của {{ $order['brand'] }}"
                            width="80"
                            height="96"
                            loading="lazy"
                            class="w-20 h-24 object-cover bg-neutral-100"
                        >
                    </a>

                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">{{ $order['brand'] }}</p>
                        <h3 class="mt-1 font-display text-xl text-black">
                            <a href="{{ $order['detail_url'] }}" class="hover:underline hover:underline-offset-4">{{ $order['name'] }}</a>
                        </h3>
                        <dl class="mt-4 grid gap-2 text-xs text-neutral-600 sm:grid-cols-2">
                            <div class="flex gap-2">
                                <dt class="uppercase tracking-wider text-neutral-400">Kích cỡ</dt>
                                <dd class="font-medium text-neutral-800">{{ $order['size'] }}</dd>
                            </div>
                            <div class="flex flex-col gap-1 sm:items-end">
                                <dt class="uppercase tracking-wider text-neutral-400">Ngày nhận — Ngày trả</dt>
                                <dd class="font-medium tabular-nums text-neutral-800">{{ $order['rental_period'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <footer class="border-t border-neutral-200 pt-5">
                    <dl class="ml-auto max-w-md space-y-3 text-sm tabular-nums">
                        <div class="flex items-center justify-between gap-6 text-neutral-600">
                            <dt>Tổng tiền thuê</dt>
                            <dd>{{ number_format($order['rental_total'], 0, ',', '.') }}đ</dd>
                        </div>
                        <div class="flex items-center justify-between gap-6 border-t border-neutral-100 pt-3 font-semibold text-black">
                            <dt>Tiền cọc đang giữ (Escrow)</dt>
                            <dd>{{ number_format($order['escrow_deposit'], 0, ',', '.') }}đ</dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex justify-end">
                        <a href="{{ $order['detail_url'] }}" class="inline-flex min-h-11 items-center border-b border-black text-[10px] font-medium uppercase tracking-widest text-black">
                            Xem chi tiết đơn
                        </a>
                    </div>
                </footer>
            </article>
        @endforeach
    </div>
@endsection
