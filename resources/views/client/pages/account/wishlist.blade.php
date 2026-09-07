@extends('client.layouts.account')

@section('title', 'Sản Phẩm Yêu Thích | LUXE ROTATE')
@section('meta_description', 'Danh sách thiết kế thời trang cao cấp đã lưu trong tài khoản LUXE ROTATE.')
@section('canonical', url('/account/wishlist'))
@section('robots', 'noindex, nofollow')

@php
    $wishlistProducts = [
        [
            'id' => 'noir-sculpted-gown',
            'image' => asset('images/editorial/black-gown.webp'),
            'position' => 'center',
            'brand' => 'Maison Élan',
            'name' => 'Noir Sculpted Gown',
            'url' => route('products.show', 'noir-sculpted-gown'),
            'status' => 'CÓ SẴN',
            'rentalPrice' => 890000,
            'deposit' => 2500000,
            'purchasePrice' => 6800000,
            'sizes' => ['XS', 'S', 'M'],
        ],
        [
            'id' => 'ivory-fluid-suit',
            'image' => asset('images/editorial/hero-campaign.webp'),
            'position' => '52% center',
            'brand' => 'Atelier Blanc',
            'name' => 'Ivory Fluid Suit',
            'url' => route('products.show', 'ivory-fluid-suit'),
            'status' => 'CÓ SẴN',
            'rentalPrice' => 760000,
            'deposit' => 2200000,
            'purchasePrice' => 5900000,
            'sizes' => ['S', 'M'],
        ],
        [
            'id' => 'graphite-column-dress',
            'image' => asset('images/editorial/city-lookbook.webp'),
            'position' => '72% center',
            'brand' => 'Studio N°5',
            'name' => 'Graphite Column Dress',
            'url' => route('products.show', 'graphite-column-dress'),
            'status' => 'CÓ SẴN',
            'rentalPrice' => 690000,
            'deposit' => 1900000,
            'purchasePrice' => 5200000,
            'sizes' => ['XS', 'S'],
        ],
    ];
@endphp

@section('account_content')
    <h1 class="text-4xl font-serif mb-10">Sản phẩm yêu thích</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($wishlistProducts as $product)
            <x-client::product-card :product="$product" />
        @endforeach
    </div>
@endsection
