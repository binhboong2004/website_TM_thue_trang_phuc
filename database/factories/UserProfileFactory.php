<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => fake()->numerify('09########'),
            'address' => fake()->address(),
            'height_cm' => fake()->numberBetween(145, 195),
            'weight_kg' => fake()->numberBetween(40, 100),
            'bust_cm' => fake()->numberBetween(70, 120),
            'waist_cm' => fake()->numberBetween(55, 110),
            'hips_cm' => fake()->numberBetween(75, 125),
            'style_preferences' => fake()->randomElements([
                'Minimalist',
                'Vintage',
                'Dạ hội',
                'Công sở',
                'Thanh lịch',
                'Avant-garde',
            ], fake()->numberBetween(1, 3)),
        ];
    }
}
