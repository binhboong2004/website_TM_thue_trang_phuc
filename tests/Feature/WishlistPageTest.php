<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\WishlistController;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class WishlistPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_wishlist_routes_use_client_controller_and_require_authentication(): void
    {
        $indexRoute = Route::getRoutes()->getByName('account.wishlist');
        $toggleRoute = Route::getRoutes()->getByName('wishlist.toggle');

        $this->assertNotNull($indexRoute);
        $this->assertNotNull($toggleRoute);
        $this->assertSame(WishlistController::class.'@index', $indexRoute->getActionName());
        $this->assertSame(WishlistController::class.'@toggle', $toggleRoute->getActionName());
        $this->assertContains('auth', $indexRoute->gatherMiddleware());
        $this->assertContains('auth', $toggleRoute->gatherMiddleware());

        $this->get(route('account.wishlist'))->assertRedirect(route('login'));
        $this->postJson(route('wishlist.toggle'), ['product_id' => 'missing-product'])->assertUnauthorized();
    }

    public function test_authenticated_user_can_view_favorite_products(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'id' => 'noir-sculpted-gown',
            'name' => 'Noir Sculpted Gown',
        ]);
        $user->favoriteProducts()->attach($product);

        $this->actingAs($user)
            ->get(route('account.wishlist'))
            ->assertOk()
            ->assertViewIs('client.pages.account.wishlist')
            ->assertViewHas('wishlists', fn (Collection $wishlists): bool => $wishlists->count() === 1
                && $wishlists->first()->is($product))
            ->assertSeeText('Sản phẩm yêu thích')
            ->assertSeeText('Noir Sculpted Gown')
            ->assertSee('visible: true', false)
            ->assertSee('x-show="visible"', false)
            ->assertSee('x-transition.opacity.duration.300ms', false)
            ->assertSee('const isWishlistPage = true', false)
            ->assertSee("if (data.status === 'removed' && isWishlistPage)", false)
            ->assertSee('visible = false', false)
            ->assertSee('aria-current="page"', false);
    }

    public function test_wishlist_page_renders_the_empty_state(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.wishlist'))
            ->assertOk()
            ->assertSeeText('Bạn chưa lưu thiết kế nào')
            ->assertSeeText('Khám phá bộ sưu tập')
            ->assertSee('href="'.route('client.shop').'"', false);
    }

    public function test_user_can_add_and_remove_a_product_without_a_page_redirect(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->postJson(route('wishlist.toggle'), ['product_id' => $product->id])
            ->assertOk()
            ->assertExactJson([
                'status' => 'added',
                'message' => 'Đã lưu vào danh sách yêu thích',
            ]);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($user)
            ->postJson(route('wishlist.toggle'), ['product_id' => $product->id])
            ->assertOk()
            ->assertExactJson([
                'status' => 'removed',
                'message' => 'Đã bỏ lưu sản phẩm',
            ]);

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_toggle_rejects_an_unknown_product(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('wishlist.toggle'), ['product_id' => 'missing-product'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('product_id');

        $this->assertDatabaseCount('wishlists', 0);
    }

    public function test_wishlist_models_expose_expected_relationships(): void
    {
        $wishlist = Wishlist::factory()->create();

        $this->assertTrue($wishlist->user->wishlists->first()->is($wishlist));
        $this->assertTrue($wishlist->product->favoritedBy->first()->is($wishlist->user));
        $this->assertContains('user_id', $wishlist->getFillable());
        $this->assertContains('product_id', $wishlist->getFillable());
    }

    public function test_product_card_and_toast_include_ajax_wishlist_behavior(): void
    {
        $product = Product::factory()->create([
            'id' => 'noir-sculpted-gown',
            'name' => 'Noir Sculpted Gown',
        ]);
        $user = User::factory()->create();
        $user->favoriteProducts()->attach($product);

        $this->actingAs($user)
            ->view('client.components.product-card', ['product' => $product])
            ->assertSee('favorited: true', false)
            ->assertSee('fetch(', false)
            ->assertSee('wishlist\/toggle', false)
            ->assertSee('const isWishlistPage = false', false)
            ->assertSee("favorited ? 'fill-white text-white drop-shadow-[0_2px_8px_rgba(0,0,0,0.5)]' : 'fill-transparent text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.6)] hover:fill-white/30'", false)
            ->assertSee('stroke-width="1.5"', false);

        $this->view('client.components.toast')
            ->assertSee('@show-toast.window="displayToast($event.detail.message)"', false)
            ->assertSee('x-text="message"', false);
    }
}
