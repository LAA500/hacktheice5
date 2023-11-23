<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::query()->create([
            'name' => 'Якутск',
        ]);

        foreach(City::all() as $city) {
            Warehouse::query()->create([
                'city_id' => $city->id,
                'name' => $city->name . '-'. Warehouse::query()->max('id') + 1,
            ]);
        }
    }
}
