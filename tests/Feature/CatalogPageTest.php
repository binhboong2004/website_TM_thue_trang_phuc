<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\CatalogController;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CatalogPageTest extends TestCase
{
    public function test_shop_route_uses_the_catalog_controller(): void
    {
        $route = Route::getRoutes()->getByName('client.shop');

        $this->assertNotNull($route);
        $this->assertSame(CatalogController::class.'@index', $route->getActionName());
        $this->assertSame(url('/shop'), route('client.shop'));
    }

    public function test_catalog_renders_filters_product_cards_and_pagination(): void
    {
        $this->get(route('client.shop'))
            ->assertOk()
            ->assertSee('Mua sắm thiết kế cao cấp')
            ->assertSee('12 sản phẩm')
            ->assertSee('Loại giao dịch')
            ->assertSee('Lịch trống')
            ->assertSee('Noir Sculpted Gown')
            ->assertSee('THUÊ ĐỒ')
            ->assertSee('MUA NGAY')
            ->assertSee('Phân trang danh mục')
            ->assertSee('page=2', false)
            ->assertSee('application/ld+json', false);
    }

    public function test_catalog_filters_by_brand(): void
    {
        $this->get(route('client.shop', ['brands' => ['Maison Élan']]))
            ->assertOk()
            ->assertViewHas('filters', fn (array $filters): bool => $filters['brands'] === ['Maison Élan'])
            ->assertSee('"numberOfItems":2', false)
            ->assertSee('Noir Sculpted Gown')
            ->assertSee('Silk Cowl Evening Dress')
            ->assertDontSee('Midnight Tuxedo');
    }

    public function test_catalog_combines_size_and_price_filters(): void
    {
        $this->get(route('client.shop', [
            'sizes' => ['XS'],
            'max_price' => 650000,
        ]))
            ->assertOk()
            ->assertSee('"numberOfItems":3', false)
            ->assertSee('Architectural White Blazer')
            ->assertSee('Slate Draped Midi')
            ->assertSee('Charcoal Sculpted Jacket')
            ->assertDontSee('Graphite Column Dress');
    }

    public function test_purchase_price_sorting_uses_purchase_price(): void
    {
        $this->get(route('client.shop', [
            'transaction' => 'purchase',
            'sort' => 'price_asc',
        ]))
            ->assertOk()
            ->assertSeeInOrder([
                'Slate Draped Midi',
                'Architectural White Blazer',
                'Charcoal Sculpted Jacket',
            ]);
    }
}
