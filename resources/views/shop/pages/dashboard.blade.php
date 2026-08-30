@extends('shop.layouts.shop')

@section('title', 'Tổng quan cửa hàng')

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Seller dashboard</p>
    <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">Tổng quan cửa hàng</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">Quản lý sản phẩm hybrid, lịch thuê và đơn mua đứt trong một không gian thống nhất.</p>
        </div>
        <a href="{{ route('shop.products.create') }}" class="button-primary self-start">Thêm sản phẩm</a>
    </div>
@endsection

@section('content')
    <section aria-labelledby="shop-metrics-title">
        <h2 id="shop-metrics-title" class="sr-only">Chỉ số cửa hàng</h2>
        <div class="grid gap-px border border-line bg-line sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($metrics as $metric)
                <article class="min-h-44 bg-paper p-6">
                    <p class="text-xs font-medium leading-5 text-muted">{{ $metric['label'] }}</p>
                    <p class="mt-7 text-3xl font-semibold tracking-tight tabular-nums">{{ $metric['value'] }}</p>
                    <p class="mt-3 text-xs text-muted">{{ $metric['detail'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-8 border border-line bg-paper" aria-labelledby="recent-orders-title">
        <header class="flex flex-col gap-3 border-b border-line px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 id="recent-orders-title" class="text-base font-semibold">Đơn hàng gần đây</h2>
                <p class="mt-1 text-xs text-muted">Đơn thuê và mua đứt mới nhất của gian hàng.</p>
            </div>
            <a href="{{ route('shop.orders.index') }}" class="text-link self-start">Xem tất cả</a>
        </header>

        @forelse ($recentOrders as $order)
            <a href="{{ route('shop.orders.show', $order['code']) }}" class="grid gap-2 border-b border-line px-6 py-5 text-sm last:border-b-0 sm:grid-cols-4">
                <span class="font-medium">{{ $order['code'] }}</span>
                <span>{{ $order['customer'] }}</span>
                <span class="text-muted">{{ $order['status'] }}</span>
                <span class="text-right tabular-nums">{{ $order['total'] }}</span>
            </a>
        @empty
            <div class="px-6 py-14 text-center">
                <p class="text-sm font-medium">Chưa có đơn hàng</p>
                <p class="mt-2 text-xs text-muted">Đơn mới sẽ xuất hiện tại đây sau khi khách hàng hoàn tất thanh toán.</p>
            </div>
        @endforelse
    </section>
@endsection