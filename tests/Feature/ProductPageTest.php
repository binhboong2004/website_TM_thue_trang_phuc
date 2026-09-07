<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    public function test_product_route_uses_the_client_product_controller(): void
    {
        $route = Route::getRoutes()->getByName('products.show');

        $this->assertNotNull($route);
        $this->assertSame(ProductController::class.'@show', $route->getActionName());
        $this->assertSame(
            url('/products/noir-sculpted-gown'),
            route('products.show', 'noir-sculpted-gown'),
        );
    }

    public function test_product_page_renders_hybrid_purchase_experience_and_seo(): void
    {
        $this->get(route('products.show', 'noir-sculpted-gown'))
            ->assertOk()
            ->assertSee('Noir Sculpted Gown')
            ->assertSee('Maison Élan')
            ->assertSee('Thử đồ ảo · VTON')
            ->assertSee('Thuê sự kiện')
            ->assertSee('Mua đứt')
            ->assertSee('Lịch khả dụng')
            ->assertSee('890.000đ')
            ->assertSee('2.500.000đ')
            ->assertSee('6.800.000đ')
            ->assertSee('AI tư vấn size')
            ->assertSee('Bảng số đo trang phục')
            ->assertSee('Quy trình hoàn cọc tự động')
            ->assertSee('Giặt hấp & khử khuẩn')
            ->assertSee('role="tablist"', false)
            ->assertSee('x-trap.noscroll="sizeModalOpen"', false)
            ->assertSee('productDetail(', false)
            ->assertSee('addRentalToCart()', false)
            ->assertSee('addPurchaseToCart()', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('property="og:type" content="product"', false)
            ->assertViewHas('product', function (array $product): bool {
                return $product['id'] === 'noir-sculpted-gown'
                    && count($product['gallery']) === 4
                    && array_keys($product['measurements']) === ['XS', 'S', 'M'];
            });
    }

    public function test_all_catalog_product_slugs_resolve_to_a_product_page(): void
    {
        $slugs = [
            'noir-sculpted-gown',
            'ivory-fluid-suit',
            'midnight-tuxedo',
            'graphite-column-dress',
            'silk-cowl-evening-dress',
            'architectural-white-blazer',
            'velvet-peak-lapel-suit',
            'slate-draped-midi',
            'monochrome-tuxedo-dress',
            'black-organza-column',
            'pearl-satin-co-ord',
            'charcoal-sculpted-jacket',
        ];

        foreach ($slugs as $slug) {
            $this->get(route('products.show', $slug))
                ->assertOk();
        }
    }

    public function test_unknown_product_returns_not_found(): void
    {
        $this->get(route('products.show', 'unknown-design'))
            ->assertNotFound();
    }
}
