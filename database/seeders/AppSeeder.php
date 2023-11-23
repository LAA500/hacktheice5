<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::ROLES as $key => $value) {
            Role::create([
                'name' => $key,
                'label' => $value,
            ]);
        }
        $user = User::query()->first();
        $user->assignRole(['admin', 'supplier', 'dealer']);
    }
}
