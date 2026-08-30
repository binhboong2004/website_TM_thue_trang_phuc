@extends('shop.layouts.shop')

@section('title', 'Đơn '.$order['code'])

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Order detail</p>
    <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">{{ $order['code'] }}</h1><p class="mt-2 text-sm text-muted">{{ $order['status'] }}</p></div>
        <a href="{{ route('shop.orders.index') }}" class="button-secondary self-start">Danh sách đơn</a>
    </div>
@endsection

@section('content')
    <div class="grid gap-8 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="border border-line bg-paper" aria-labelledby="order-items-title">
            <header class="border-b border-line px-6 py-5"><h2 id="order-items-title" class="text-base font-semibold">Sản phẩm trong đơn</h2></header>
            @forelse ($order['items'] as $item)
                <article class="grid gap-2 border-b border-line px-6 py-5 text-sm last:border-b-0 sm:grid-cols-3"><span class="font-medium">{{ $item['name'] }}</span><span>{{ $item['type'] }}</span><span class="sm:text-right tabular-nums">{{ $item['total'] }}</span></article>
            @empty
                <div class="px-6 py-14 text-center text-sm text-muted">Chưa có dữ liệu sản phẩm để hiển thị.</div>
            @endforelse
        </section>

        <aside class="border border-line bg-paper p-6" aria-labelledby="order-summary-title">
            <h2 id="order-summary-title" class="text-base font-semibold">Tóm tắt đơn</h2>
            <dl class="mt-6 space-y-4 text-sm"><div class="flex justify-between gap-4"><dt class="text-muted">Khách hàng</dt><dd class="text-right">{{ $order['customer'] }}</dd></div><div class="flex justify-between gap-4"><dt class="text-muted">Trạng thái</dt><dd class="text-right">{{ $order['status'] }}</dd></div><div class="flex justify-between gap-4 border-t border-line pt-4"><dt>Tổng thanh toán</dt><dd class="font-semibold tabular-nums">{{ $order['total'] }}</dd></div></dl>
        </aside>
    </div>
@endsection