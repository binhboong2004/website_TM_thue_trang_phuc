@extends('shop.layouts.shop')

@section('title', 'Thêm sản phẩm')

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Catalog / Create</p>
    <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Thêm sản phẩm mới</h1>
    <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">Chuẩn bị thông tin giá thuê, tiền cọc và giá mua đứt cho một thiết kế hybrid.</p>
@endsection

@section('content')
    <form class="max-w-4xl border border-line bg-paper p-6 sm:p-8" aria-labelledby="create-product-form-title">
        <h2 id="create-product-form-title" class="text-lg font-semibold">Thông tin cơ bản</h2>
        <p class="mt-2 text-xs leading-5 text-muted">Biểu mẫu giao diện đã sẵn sàng; nút lưu sẽ được kích hoạt khi Product model và nghiệp vụ kho được kết nối.</p>
        <div class="mt-7">@include('shop.partials.product-fields')</div>
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('shop.products.index') }}" class="button-secondary">Quay lại</a>
            <button type="button" class="button-primary cursor-not-allowed opacity-40" disabled>Lưu sản phẩm</button>
        </div>
    </form>
@endsection