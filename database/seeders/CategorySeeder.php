<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Молочные продукты',
            'Верхняя одежда',
            'Овощи',
            'Фрукты',
            'Крупы',
            'Макароны',
            'Бытовая химия',
            'Товары для дома',
        ];

        foreach ($categories as $key => $category) {
            Category::query()->create([
                'name' => $category,
                'description' => fake()->realText(),
            ]);
        }
    }
}
