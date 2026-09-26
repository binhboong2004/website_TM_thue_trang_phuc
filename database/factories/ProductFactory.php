<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->slug(3),
            'brand' => fake()->company(),
            'name' => fake()->words(3, true),
            'image' => 'images/editorial/black-gown.webp',
            'position' => 'center',
            'status' => 'CÓ SẴN',
            'rental_price' => fake()->numberBetween(500000, 1000000),
            'deposit' => fake()->numberBetween(1500000, 3000000),
            'purchase_price' => fake()->numberBetween(4000000, 8000000),
            'sizes' => ['S', 'M'],
        ];
    }
}
