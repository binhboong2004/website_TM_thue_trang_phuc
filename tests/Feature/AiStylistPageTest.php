<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\VirtualFittingController;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AiStylistPageTest extends TestCase
{
    public function test_ai_stylist_widget_is_available_from_the_client_layout(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSee('id="ai-stylist-widget"', false)
            ->assertSee('x-data="{ open: false }"', false)
            ->assertSee('id="ai-stylist-dialog"', false)
            ->assertSeeText('Trợ Lý Phong Cách')
            ->assertSee('id="global-ai-stylist-input"', false)
            ->assertSee('@ai-stylist-open.window', false);
    }

    public function test_virtual_fitting_route_uses_the_dedicated_controller_and_view(): void
    {
        $route = Route::getRoutes()->getByName('client.virtual-fitting');

        $this->assertNotNull($route);
        $this->assertSame(VirtualFittingController::class.'@index', $route->getActionName());

        $this->get(route('client.virtual-fitting'))
            ->assertOk()
            ->assertViewIs('client.pages.virtual-fitting.index')
            ->assertViewHas('product')
            ->assertSeeText('Phòng Thử Đồ Ảo')
            ->assertSeeText('Hình dung thiết kế trên chính vóc dáng của bạn');
    }

    public function test_virtual_fitting_room_exposes_upload_analysis_result_and_commerce_controls(): void
    {
        $this->get(route('client.virtual-fitting'))
            ->assertOk()
            ->assertSee('accept="image/jpeg,image/png,image/webp"', false)
            ->assertSee('@drop.prevent="handleDrop($event)"', false)
            ->assertSeeText('Kéo thả ảnh chân dung / toàn thân')
            ->assertSeeText('Độ phù hợp form dáng')
            ->assertSeeText('Khuyến nghị size')
            ->assertSeeText('Thuê / ngày')
            ->assertSeeText('Mua đứt')
            ->assertSeeText('Thêm vào giỏ')
            ->assertSee('addToCart()', false)
            ->assertSee('$store.cart.addPurchase', false);
    }

    public function test_legacy_ai_stylist_url_permanently_redirects_to_virtual_fitting_room(): void
    {
        $this->get(route('client.ai-stylist'))
            ->assertStatus(301)
            ->assertRedirect(route('client.virtual-fitting'));
    }
}
