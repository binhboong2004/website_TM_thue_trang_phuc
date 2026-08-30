@extends('shop.layouts.shop')

@section('title', 'Đơn hàng')

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Orders</p>
    <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Quản lý đơn hàng</h1>
    <p class="mt-2 text-sm text-muted">Theo dõi riêng đơn thuê theo lịch và sản phẩm mua đứt.</p>
@endsection

@section('content')
    <section class="border border-line bg-paper" aria-labelledby="order-list-title">
        <header class="border-b border-line px-6 py-5"><h2 id="order-list-title" class="text-base font-semibold">Tất cả đơn hàng</h2></header>
        @forelse ($orders as $order)
            <a href="{{ route('shop.orders.show', $order['code']) }}" class="grid gap-3 border-b border-line px-6 py-5 text-sm last:border-b-0 sm:grid-cols-4 sm:items-center">
                <span class="font-medium">{{ $order['code'] }}</span><span>{{ $order['customer'] }}</span><span class="text-muted">{{ $order['status'] }}</span><span class="sm:text-right tabular-nums">{{ $order['total'] }}</span>
            </a>
        @empty
            <div class="px-6 py-16 text-center"><p class="font-medium">Chưa có đơn hàng</p><p class="mt-2 text-xs text-muted">Các đơn thuộc gian hàng sẽ xuất hiện tại đây.</p></div>
        @endforelse
    </section>
@endsection