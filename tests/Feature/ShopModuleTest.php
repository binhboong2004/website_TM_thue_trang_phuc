<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ShopModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_routes_use_the_required_security_middleware(): void
    {
        foreach (['shop.dashboard', 'shop.products.index', 'shop.orders.index'] as $routeName) {
            $route = Route::getRoutes()->getByName($routeName);

            $this->assertNotNull($route);
            $this->assertContains('auth', $route->gatherMiddleware());
            $this->assertContains('verified', $route->gatherMiddleware());
            $this->assertContains('is_shop', $route->gatherMiddleware());
        }
    }

    public function test_regular_client_cannot_access_shop_workspace(): void
    {
        $client = User::factory()->create();

        $this->actingAs($client)
            ->get(route('shop.dashboard'))
            ->assertForbidden();
    }

    public function test_shop_user_can_access_all_seller_pages(): void
    {
        $shop = User::factory()->shop()->create();

        $this->actingAs($shop)
            ->get(route('shop.dashboard'))
            ->assertOk()
            ->assertSee('Tổng quan cửa hàng');

        $this->actingAs($shop)
            ->get(route('shop.products.index'))
            ->assertOk()
            ->assertSee('Quản lý sản phẩm');

        $this->actingAs($shop)
            ->get(route('shop.products.create'))
            ->assertOk()
            ->assertSee('Thêm sản phẩm mới');

        $this->actingAs($shop)
            ->get(route('shop.products.edit', 'noir-sculpted-gown'))
            ->assertOk()
            ->assertSee('Chỉnh sửa sản phẩm');

        $this->actingAs($shop)
            ->get(route('shop.orders.index'))
            ->assertOk()
            ->assertSee('Quản lý đơn hàng');

        $this->actingAs($shop)
            ->get(route('shop.orders.show', 'LR-2026-0001'))
            ->assertOk()
            ->assertSee('LR-2026-0001');
    }

    public function test_public_catalog_and_seller_dashboard_have_distinct_urls(): void
    {
        $this->assertSame(url('/shop'), route('client.shop'));
        $this->assertSame(url('/shop/dashboard'), route('shop.dashboard'));
    }
}
