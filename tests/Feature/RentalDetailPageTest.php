<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\RentalOrderController;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RentalDetailPageTest extends TestCase
{
    public function test_rental_detail_route_uses_the_client_controller(): void
    {
        $route = Route::getRoutes()->getByName('account.rentals.show');

        $this->assertNotNull($route);
        $this->assertSame(RentalOrderController::class.'@show', $route->getActionName());
    }

    public function test_rental_detail_page_renders_lifecycle_escrow_and_evidence_tools(): void
    {
        $this->get(route('account.rentals.show', 'LR-2026-0001'))
            ->assertOk()
            ->assertSee('Theo dõi đơn thuê')
            ->assertSee('Đã đặt &amp; đóng băng cọc', false)
            ->assertSee('Shop đóng gói &amp; giao', false)
            ->assertSee('Đang sử dụng')
            ->assertSee('Trả hàng &amp; kiểm tra', false)
            ->assertSee('Hoàn tất &amp; hoàn cọc', false)
            ->assertSee('Tiền cọc đang giữ trung gian')
            ->assertSee('2.500.000')
            ->assertSee('Đối soát khi nhận đồ')
            ->assertSee('Đối soát khi trả đồ')
            ->assertSee('rentalEvidence(', false)
            ->assertSee('accept="image/jpeg,image/png,image/webp,video/mp4,video/quicktime"', false)
            ->assertSee('noindex, nofollow', false);
    }
}
