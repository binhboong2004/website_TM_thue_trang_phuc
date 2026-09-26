<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\PasswordController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_routes_are_registered_and_require_authentication(): void
    {
        $editRoute = Route::getRoutes()->getByName('account.password');
        $updateRoute = Route::getRoutes()->getByName('account.password.update');

        $this->assertNotNull($editRoute);
        $this->assertNotNull($updateRoute);
        $this->assertSame(PasswordController::class.'@edit', $editRoute->getActionName());
        $this->assertSame(PasswordController::class.'@update', $updateRoute->getActionName());
        $this->assertContains('auth', $editRoute->gatherMiddleware());
        $this->assertContains('auth', $updateRoute->gatherMiddleware());

        $this->get(route('account.password'))->assertRedirect(route('login'));
        $this->put(route('account.password.update'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_password_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.password'))
            ->assertOk()
            ->assertViewIs('client.pages.account.password')
            ->assertSee('action="'.route('account.password.update').'"', false)
            ->assertSee('name="_method" value="PUT"', false)
            ->assertSeeText('Đổi mật khẩu')
            ->assertSeeText('Cập nhật mật khẩu');
    }

    public function test_authenticated_user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('account.password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response
            ->assertRedirect(route('account.password'))
            ->assertSessionHas('success', 'Mật khẩu của bạn đã được cập nhật thành công.');

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_incorrect_current_password_is_rejected_without_changing_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user)
            ->from(route('account.password'))
            ->put(route('account.password.update'), [
                'current_password' => 'incorrect-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('account.password'))
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }

    public function test_new_password_must_be_at_least_eight_characters_and_confirmed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user)
            ->from(route('account.password'))
            ->put(route('account.password.update'), [
                'current_password' => 'old-password',
                'password' => 'short',
                'password_confirmation' => 'different',
            ])
            ->assertRedirect(route('account.password'))
            ->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }
}
