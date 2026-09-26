<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_seeder_creates_three_role_accounts_and_customer_profile_idempotently(): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('users', 3);

        $admin = User::query()->where('email', 'admin@gmail.com')->sole();
        $this->assertSame('Binh Admin', $admin->name);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_shop);
        $this->assertTrue(Hash::check('bxt1vcvc', $admin->password));

        $shop = User::query()->where('email', 'shop@gmail.com')->sole();
        $this->assertSame('Binh Shop (Shop)', $shop->name);
        $this->assertFalse($shop->is_admin);
        $this->assertTrue($shop->is_shop);
        $this->assertTrue(Hash::check('bxt1vcvc', $shop->password));

        $customer = User::query()->where('email', 'vuduybinh@gmail.com')->sole();
        $this->assertSame('Vũ Duy Bình', $customer->name);
        $this->assertFalse($customer->is_admin);
        $this->assertFalse($customer->is_shop);
        $this->assertTrue(Hash::check('bxt1vcvc', $customer->password));
        $this->assertNotNull($customer->email_verified_at);

        $this->assertDatabaseCount('user_profiles', 1);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $customer->id,
            'height_cm' => 170,
            'weight_kg' => 65,
        ]);
    }
}
