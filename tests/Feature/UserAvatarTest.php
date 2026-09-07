<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_avatar_can_be_mass_assigned_and_resolves_to_public_storage(): void
    {
        $user = User::factory()->create([
            'avatar' => 'avatars/editorial-portrait.jpg',
        ]);

        $this->assertSame('avatars/editorial-portrait.jpg', $user->avatar);
        $this->assertSame(asset('storage/avatars/editorial-portrait.jpg'), $user->avatar_url);
    }

    public function test_missing_avatar_resolves_to_a_monochrome_ui_avatar(): void
    {
        $user = User::factory()->make([
            'name' => 'Linh Nguyễn',
            'avatar' => null,
        ]);

        $this->assertSame(
            'https://ui-avatars.com/api/?name=Linh%20Nguy%E1%BB%85n&color=FFFFFF&background=0A0A0A',
            $user->avatar_url,
        );
    }
}
