<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            UserSeeder::class,
            AppSeeder::class,
            ShopSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,

            WarehouseSeeder::class,
        ]);
    }
}
