<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\House_history;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\HouseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            HouseSeeder::class,
        ]);
    }
}
