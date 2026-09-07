<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\LookbookController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LookbookPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_lookbook_route_uses_the_client_controller(): void
    {
        $route = Route::getRoutes()->getByName('client.lookbook');

        $this->assertNotNull($route);
        $this->assertSame('lookbook', $route->uri());
        $this->assertSame(LookbookController::class.'@index', $route->getActionName());
    }

    public function test_guest_can_browse_the_shoppable_masonry_lookbook(): void
    {
        $response = $this->get(route('client.lookbook'));

        $response
            ->assertOk()
            ->assertViewIs('client.pages.lookbook.index')
            ->assertViewHas('looks', fn (array $looks): bool => count($looks) === 8)
            ->assertViewHas('breadcrumbs', fn (array $breadcrumbs): bool => $breadcrumbs[1]['name'] === 'Lookbook')
            ->assertSee('LOOKBOOK')
            ->assertSee('Lấy cảm hứng từ cộng đồng. Chọn Thuê ngay những thiết kế xuất hiện trong khung hình.')
            ->assertSee('columns-2', false)
            ->assertSee('md:columns-3', false)
            ->assertSee('lg:columns-4', false)
            ->assertSee('break-inside-avoid', false)
            ->assertSee('aria-haspopup="dialog"', false)
            ->assertSee('Chạm vào điểm đánh dấu để khám phá thiết kế')
            ->assertSee('Thuê ngay')
            ->assertSee(route('products.show', ['slug' => 'noir-sculpted-gown', 'mode' => 'rent']), false)
            ->assertDontSee('Chia sẻ phong cách của bạn');
    }

    public function test_share_style_action_is_only_visible_to_authenticated_clients(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('client.lookbook'))
            ->assertOk()
            ->assertSee('Chia sẻ phong cách của bạn')
            ->assertSee('mailto:lookbook@luxerotate.vn', false);
    }
}
