<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_one_profile_with_cast_style_preferences(): void
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->for($user)->create([
            'style_preferences' => ['Minimalist', 'Dạ hội'],
        ]);

        $this->assertTrue($user->profile->is($profile));
        $this->assertTrue($profile->user->is($user));
        $this->assertSame(['Minimalist', 'Dạ hội'], $profile->style_preferences);
    }

    public function test_profile_is_deleted_when_its_user_is_deleted(): void
    {
        $profile = UserProfile::factory()->create();
        $profileId = $profile->id;

        $profile->user->delete();

        $this->assertDatabaseMissing('user_profiles', ['id' => $profileId]);
    }
}
