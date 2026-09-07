<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_pages_are_available_to_guests(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Đăng Nhập')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false);

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Tạo Tài Khoản')
            ->assertSee('name="name"', false)
            ->assertSee('name="password_confirmation"', false);
    }

    public function test_auth_routes_use_expected_middleware(): void
    {
        foreach (['login', 'register'] as $routeName) {
            $route = Route::getRoutes()->getByName($routeName);

            $this->assertNotNull($route);
            $this->assertContains('guest', $route->gatherMiddleware());
        }

        $logoutRoute = Route::getRoutes()->getByName('logout');

        $this->assertNotNull($logoutRoute);
        $this->assertContains('auth', $logoutRoute->gatherMiddleware());
    }

    public function test_client_can_register(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Linh Nguyễn',
            'email' => 'linh@example.com',
            'password' => 'Luxury!2026',
            'password_confirmation' => 'Luxury!2026',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Linh Nguyễn',
            'email' => 'linh@example.com',
            'is_admin' => false,
            'is_shop' => false,
        ]);
    }

    public function test_client_can_login_and_logout(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Luxury!2026'),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'Luxury!2026',
            'remember' => true,
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'incorrect-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
