<?php

namespace Tests\Feature;

use App\Http\Controllers\Shop\InventoryController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ShopInventoryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_route_is_protected_by_shop_middleware(): void
    {
        $route = Route::getRoutes()->getByName('shop.inventory.index');

        $this->assertNotNull($route);
        $this->assertSame(InventoryController::class.'@index', $route->getActionName());
        $this->assertContains('auth', $route->gatherMiddleware());
        $this->assertContains('verified', $route->gatherMiddleware());
        $this->assertContains('is_shop', $route->gatherMiddleware());
    }

    public function test_shop_can_view_physical_inventory_timeline(): void
    {
        $shop = User::factory()->shop()->create();

        $this->actingAs($shop)
            ->get(route('shop.inventory.index'))
            ->assertOk()
            ->assertSee('Kho món đồ vật lý')
            ->assertSee('Mẫu thiết kế')
            ->assertSee('Garment Item')
            ->assertSee('NSG-S-001')
            ->assertSee('LR-NSG-S-001')
            ->assertSee('Đang cho thuê')
            ->assertSee('Đệm giặt hấp')
            ->assertSee('Bảo dưỡng')
            ->assertSee('inventoryWorkspace(', false);
    }
}
