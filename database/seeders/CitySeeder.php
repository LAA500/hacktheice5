<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            //Абыйский
            [
                'name' => 'Белая Гора',
                'district' => 'Абыйский улус',
                'population' => 1900,
            ],
            [
                'name' => 'Абый',
                'district' => 'Абыйский улус',
                'population' => 500,
            ],
            [
                'name' => 'Сыаганнах',
                'district' => 'Абыйский улус',
                'population' => 420,
            ],

            //Аллаиховский
            [
                'name' => 'Чокурдах',
                'district' => 'Аллаиховский улус',
                'population' => 1800,
            ],
            [
                'name' => 'Русское Устье',
                'district' => 'Аллаиховский улус',
                'population' => 157,
            ],
            [
                'name' => 'Оленегорск',
                'district' => 'Аллаиховский улус',
                'population' => 254,
            ],

            //Верхнеколымский
            [
                'name' => 'Зырянка',
                'district' => 'Верхнеколымский улус',
                'population' => 2521,
            ],
            [
                'name' => 'Верхнеколымск',
                'district' => 'Верхнеколымский улус',
                'population' => 365,
            ],
            [
                'name' => 'Угольное',
                'district' => 'Верхнеколымский улус',
                'population' => 329,
            ],

            //Жиганский
            [
                'name' => 'Жиганск',
                'district' => 'Жиганский улус',
                'population' => 3420,
            ],
            [
                'name' => 'Бестях',
                'district' => 'Жиганский улус',
                'population' => 218,
            ],
            [
                'name' => 'Кыстатыам',
                'district' => 'Жиганский улус',
                'population' => 397,
            ],
        ];

        collect($cities)->each(function ($city) {
            City::query()->create($city);
        });
    }
}
