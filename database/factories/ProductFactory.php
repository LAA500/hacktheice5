<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'shop_id' => fake()->randomElement(\App\Models\Shop::pluck('id')),
            'name' => (string) fake()->words(1, true),
            'description' => fake()->realText(),
            'barcode' => fake()->numberBetween(100000000000, 99999999999999),
        ];
    }
}
