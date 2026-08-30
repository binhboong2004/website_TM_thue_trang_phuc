@extends('shop.layouts.shop')

@section('title', 'Sản phẩm')

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Catalog</p>
    <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">Quản lý sản phẩm</h1>
            <p class="mt-2 text-sm text-muted">Theo dõi giá thuê, giá mua, tiền cọc và trạng thái tồn kho.</p>
        </div>
        <a href="{{ route('shop.products.create') }}" class="button-primary self-start">Thêm sản phẩm</a>
    </div>
@endsection

@section('content')
    <section class="overflow-hidden border border-line bg-paper" aria-labelledby="product-list-title">
        <h2 id="product-list-title" class="sr-only">Danh sách sản phẩm</h2>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[52rem] text-left text-sm">
                <thead class="border-b border-line bg-fog text-[10px] uppercase tracking-[0.14em] text-muted">
                    <tr><th class="px-5 py-4 font-semibold">Sản phẩm</th><th class="px-5 py-4 font-semibold">Giá thuê</th><th class="px-5 py-4 font-semibold">Giá mua</th><th class="px-5 py-4 font-semibold">Trạng thái</th><th class="px-5 py-4 text-right font-semibold">Thao tác</th></tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-5 py-5"><p class="font-medium">{{ $product['name'] }}</p><p class="mt-1 text-xs text-muted">{{ $product['brand'] }}</p></td>
                            <td class="px-5 py-5 tabular-nums">{{ $product['rental_price'] }}</td>
                            <td class="px-5 py-5 tabular-nums">{{ $product['purchase_price'] }}</td>
                            <td class="px-5 py-5">{{ $product['status'] }}</td>
                            <td class="px-5 py-5 text-right"><a href="{{ route('shop.products.edit', $product['slug']) }}" class="text-link">Chỉnh sửa</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-16 text-center"><p class="font-medium">Chưa có sản phẩm</p><p class="mt-2 text-xs text-muted">Tạo sản phẩm đầu tiên để bắt đầu nhận đơn thuê và mua.</p><a href="{{ route('shop.products.create') }}" class="button-secondary mt-6">Tạo sản phẩm</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection