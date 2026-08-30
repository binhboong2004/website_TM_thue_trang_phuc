@extends('shop.layouts.shop')

@section('title', 'Chỉnh sửa sản phẩm')

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Catalog / Edit</p>
    <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Chỉnh sửa sản phẩm</h1>
    <p class="mt-2 text-sm text-muted">{{ $product['name'] }}</p>
@endsection

@section('content')
    <form class="max-w-4xl border border-line bg-paper p-6 sm:p-8" aria-labelledby="edit-product-form-title">
        <h2 id="edit-product-form-title" class="text-lg font-semibold">Thông tin sản phẩm</h2>
        <p class="mt-2 text-xs leading-5 text-muted">Mã định danh: <span class="font-medium text-ink">{{ $product['slug'] }}</span></p>
        <div class="mt-7">@include('shop.partials.product-fields', ['product' => $product])</div>
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('shop.products.index') }}" class="button-secondary">Quay lại</a>
            <button type="button" class="button-primary cursor-not-allowed opacity-40" disabled>Lưu thay đổi</button>
        </div>
    </form>
@endsection