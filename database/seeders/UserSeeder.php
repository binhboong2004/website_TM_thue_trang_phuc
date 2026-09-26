<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Binh Admin',
                'password' => Hash::make('bxt1vcvc'),
            ],
        );
        $admin->forceFill([
            'email_verified_at' => now(),
            'is_admin' => true,
            'is_shop' => false,
        ])->save();

        $shop = User::query()->updateOrCreate(
            ['email' => 'shop@gmail.com'],
            [
                'name' => 'Binh Shop (Shop)',
                'password' => Hash::make('bxt1vcvc'),
            ],
        );
        $shop->forceFill([
            'email_verified_at' => now(),
            'is_admin' => false,
            'is_shop' => true,
        ])->save();

        $customer = User::query()->updateOrCreate(
            ['email' => 'vuduybinh@gmail.com'],
            [
                'name' => 'Vũ Duy Bình',
                'password' => Hash::make('bxt1vcvc'),
            ],
        );
        $customer->forceFill([
            'email_verified_at' => now(),
            'is_admin' => false,
            'is_shop' => false,
        ])->save();

        $customer->profile()->updateOrCreate(
            ['user_id' => $customer->id],
            [
                'height_cm' => 170,
                'weight_kg' => 65,
            ],
        );
    }
}
