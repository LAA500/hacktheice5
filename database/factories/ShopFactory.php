<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => fake()->randomElement(City::pluck('id')),
            'name' => fake()->word(),
            'address' => fake()->address(),
            'phone' => str_limit(fake()->e164PhoneNumber(), 11, ''),
            'schedule' => null,
        ];
    }
}
