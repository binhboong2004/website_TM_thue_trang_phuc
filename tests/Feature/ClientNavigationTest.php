<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\CatalogController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ClientNavigationTest extends TestCase
{
    public function test_client_navigation_routes_are_registered_with_expected_urls(): void
    {
        $this->assertSame(url('/shop'), route('client.shop'));
        $this->assertSame(url('/shop?type=rent'), route('client.shop', ['type' => 'rent']));
        $this->assertSame(url('/shop?type=buy'), route('client.shop', ['type' => 'buy']));
        $this->assertSame(url('/brands'), route('client.brands'));
        $this->assertSame(url('/lookbook'), route('client.lookbook'));
        $this->assertSame(url('/virtual-fitting'), route('client.virtual-fitting'));
        $this->assertSame(url('/ai-stylist'), route('client.ai-stylist'));

        $shopRoute = Route::getRoutes()->getByName('client.shop');

        $this->assertNotNull($shopRoute);
        $this->assertSame(CatalogController::class.'@index', $shopRoute->getActionName());
    }

    public function test_shop_type_query_activates_the_matching_catalogue_transaction_filter(): void
    {
        $this->get(route('client.shop', ['type' => 'rent']))
            ->assertOk()
            ->assertViewHas('filters', fn (array $filters): bool => $filters['transaction'] === 'rental');

        $this->get(route('client.shop', ['type' => 'buy']))
            ->assertOk()
            ->assertViewHas('filters', fn (array $filters): bool => $filters['transaction'] === 'purchase');
    }

    public function test_header_exposes_clickable_client_navigation_links(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSee('href="'.route('client.shop', ['type' => 'rent']).'"', false)
            ->assertSee('href="'.route('client.shop', ['type' => 'buy']).'"', false)
            ->assertSee('href="'.route('client.brands').'"', false)
            ->assertSee('href="'.route('client.lookbook').'"', false)
            ->assertSee('href="'.route('client.virtual-fitting').'"', false)
            ->assertSeeText('Thử đồ ảo')
            ->assertSee('class="nav-underline', false);
    }

    public function test_guest_account_dropdown_exposes_authentication_actions(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('x-data="{ userMenuOpen: false }"', false)
            ->assertSee('@mouseenter="userMenuOpen = true"', false)
            ->assertSee('id="user-account-menu"', false)
            ->assertSee('class="w-36 rounded-none border border-neutral-200 bg-white shadow-xl"', false)
            ->assertSee('role="menu"', false)
            ->assertSee('href="'.route('login').'"', false)
            ->assertSee('href="'.route('register').'"', false)
            ->assertSeeText('Đăng nhập')
            ->assertSeeText('Đăng ký');
    }

    public function test_authenticated_account_dropdown_matches_account_navigation(): void
    {
        $user = User::factory()->make([
            'avatar' => 'avatars/client-avatar.jpg',
        ]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSeeText($user->name)
            ->assertSee('src="'.asset('storage/avatars/client-avatar.jpg').'"', false)
            ->assertSee('href="'.route('profile.edit').'"', false)
            ->assertSeeText('Hồ sơ cá nhân')
            ->assertSee('Đơn thuê & Cọc', false)
            ->assertSee('href="'.route('account.wishlist').'"', false)
            ->assertSeeText('Sản phẩm yêu thích')
            ->assertSee('href="'.route('account.password').'"', false)
            ->assertSeeText('Đổi mật khẩu')
            ->assertDontSeeText('Đăng Lookbook')
            ->assertSee('class="border-t border-neutral-100 my-1"', false)
            ->assertSee('action="'.route('logout').'"', false)
            ->assertSeeText('Đăng xuất');
    }

    public function test_client_navigation_destination_pages_render(): void
    {
        $this->get(route('client.brands'))
            ->assertOk()
            ->assertSee('Những tên tuổi định hình tủ đồ đương đại.');

        $this->get(route('client.lookbook'))
            ->assertOk()
            ->assertSee('Lookbook');

        $this->get(route('client.virtual-fitting'))
            ->assertOk()
            ->assertSee('Phòng Thử Đồ Ảo');
    }
}
