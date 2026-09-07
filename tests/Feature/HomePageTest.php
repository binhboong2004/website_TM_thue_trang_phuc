<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_renders_inherited_layout_global_commerce_ui_and_seo_metadata(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Một tủ đồ.', false)
            ->assertSee('AI Stylist')
            ->assertSee('property="og:title"', false)
            ->assertSee('rel="canonical"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('Đồ thuê theo lịch')
            ->assertSee('Sản phẩm mua đứt')
            ->assertSee('x-data="siteHeader"', false)
            ->assertSee('Thuê: 890.000đ', false)
            ->assertSee('Cọc: 2.500.000đ', false)
            ->assertSee('Mua đứt: 6.800.000đ', false)
            ->assertSee('THUÊ ĐỒ')
            ->assertSee('MUA NGAY')
            ->assertSee('CÓ SẴN')
            ->assertSee('addPurchaseToCart()', false)
            ->assertSee('confirmRental()', false)
            ->assertSee('x-teleport="body"', false);
    }

    public function test_multi_page_commerce_routes_are_registered_with_expected_urls(): void
    {
        $routeNames = [
            'home',
            'client.shop',
            'collections.show',
            'products.show',
            'search',
            'client.brands',
            'client.brands.show',
            'client.lookbook',
            'client.virtual-fitting',
            'client.ai-stylist',
            'checkout',
            'account.rentals.show',
        ];

        foreach ($routeNames as $routeName) {
            $this->assertTrue(Route::has($routeName), "Route [{$routeName}] is not registered.");
        }

        $this->assertSame(url('/collections/vay-da-hoi'), route('collections.show', 'vay-da-hoi'));
        $this->assertSame(url('/products/noir-sculpted-gown'), route('products.show', 'noir-sculpted-gown'));
        $this->assertSame(url('/account/rentals/LR-2026-0001'), route('account.rentals.show', 'LR-2026-0001'));
    }
}
