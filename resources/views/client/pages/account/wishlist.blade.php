@extends('client.layouts.account')

@section('title', 'Sản Phẩm Yêu Thích | LUXE ROTATE')
@section('meta_description', 'Danh sách thiết kế thời trang cao cấp đã lưu trong tài khoản LUXE ROTATE.')
@section('canonical', url('/account/wishlist'))
@section('robots', 'noindex, nofollow')

@section('account_content')
    <h1 class="mb-8 font-serif text-3xl">Sản phẩm yêu thích</h1>

    @if ($wishlists->isEmpty())
        <div class="border border-neutral-200 p-12 text-center">
            <p class="mb-2 font-serif text-xl">Bạn chưa lưu thiết kế nào</p>
            <p class="mb-6 text-xs leading-6 text-neutral-500">Lưu những thiết kế bạn yêu thích để dễ dàng quay lại và lựa chọn khi cần.</p>
            <a href="{{ route('client.shop') }}" class="inline-flex min-h-12 items-center justify-center rounded-none bg-black px-8 py-4 text-[10px] font-medium uppercase tracking-widest text-white transition-colors hover:bg-neutral-800">
                Khám phá bộ sưu tập
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($wishlists as $item)
                <x-client::product-card :product="$item" />
            @endforeach
        </div>
    @endif
@endsection
