<?php

namespace Tests\Feature;

use App\Http\Controllers\Client\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_routes_are_registered_and_require_authentication(): void
    {
        $editRoute = Route::getRoutes()->getByName('profile.edit');
        $updateRoute = Route::getRoutes()->getByName('profile.update');

        $this->assertNotNull($editRoute);
        $this->assertNotNull($updateRoute);
        $this->assertSame(ProfileController::class.'@edit', $editRoute->getActionName());
        $this->assertSame(ProfileController::class.'@update', $updateRoute->getActionName());
        $this->assertContains('auth', $editRoute->gatherMiddleware());
        $this->assertContains('auth', $updateRoute->gatherMiddleware());

        $this->get(route('profile.edit'))->assertRedirect(route('login'));
        $this->put(route('profile.update'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_profile_form_with_eager_loaded_profile(): void
    {
        $user = User::factory()->hasProfile([
            'height_cm' => 168,
            'style_preferences' => ['Minimalist', 'Evening'],
        ])->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertViewIs('client.pages.account.profile')
            ->assertViewHas('user', fn (User $viewUser): bool => $viewUser->is($user)
                && $viewUser->relationLoaded('profile'))
            ->assertSee('action="'.route('profile.update').'"', false)
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="_method" value="PUT"', false)
            ->assertSee('x-data="{', false)
            ->assertSeeText('Thông Số Hình Thể')
            ->assertSeeText('Lưu thay đổi');
    }

    public function test_authenticated_user_can_update_account_and_ai_stylist_profile_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Linh Nguyễn',
            'phone' => '0901 234 567',
            'address' => '12 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh',
            'height_cm' => 168,
            'weight_kg' => 52,
            'bust_cm' => 84,
            'waist_cm' => 64,
            'hips_cm' => 90,
            'style_preferences' => ['Minimalist', 'Dạ hội'],
        ]);

        $response
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHas('success', 'Hồ sơ của bạn đã được cập nhật thành công.');

        $user->refresh();

        $this->assertSame('Linh Nguyễn', $user->name);
        $this->assertSame('0901 234 567', $user->profile->phone);
        $this->assertSame(['Minimalist', 'Dạ hội'], $user->profile->style_preferences);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'address' => '12 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh',
            'height_cm' => 168,
            'weight_kg' => 52,
            'bust_cm' => 84,
            'waist_cm' => 64,
            'hips_cm' => 90,
        ]);
    }

    public function test_update_reuses_the_existing_profile_record(): void
    {
        $user = User::factory()->hasProfile([
            'phone' => '0900000000',
        ])->create();

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'phone' => '0911111111',
            'style_preferences' => ['Vintage'],
        ])->assertRedirect(route('profile.edit'));

        $this->assertDatabaseCount('user_profiles', 1);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'phone' => '0911111111',
        ]);
    }

    public function test_user_can_replace_avatar_on_the_public_disk(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avatar' => 'avatars/old-avatar.jpg',
        ]);
        Storage::disk('public')->put($user->avatar, 'old-avatar');

        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=',
            true,
        );
        $this->assertIsString($png);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'avatar' => UploadedFile::fake()
                ->createWithContent('new-avatar.png', $png)
                ->mimeType('image/png'),
        ]);

        $response->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
        Storage::disk('public')->assertMissing('avatars/old-avatar.jpg');
    }

    public function test_invalid_measurements_and_avatar_are_rejected(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)->from(route('profile.edit'))->put(route('profile.update'), [
            'name' => '',
            'avatar' => UploadedFile::fake()->create('avatar.pdf', 100, 'application/pdf'),
            'height_cm' => 99,
            'weight_kg' => 301,
            'style_preferences' => ['Minimalist', 'Minimalist'],
        ])->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors([
                'name',
                'avatar',
                'height_cm',
                'weight_kg',
                'style_preferences.1',
            ]);

        $this->assertDatabaseMissing('user_profiles', ['user_id' => $user->id]);
    }
}
