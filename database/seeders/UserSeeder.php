<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Category;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 19; $i++) {
            User::create([
                'full_name' => $faker->name,
                'phone_number' => '0852160005' . Str::padLeft($i, 2, '0'),
                'photo_ktp' => $faker->imageUrl(640, 480, 'people', true, 'Faker'),
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('123123123'),
                'role' => 'user',
                'status' => $faker->randomElement(['tetap', 'kontrak']),
                'is_married' => $faker->boolean,
            ]);
        }

        User::create([
            'full_name' => 'Admin',
            'phone_number' => '085216000521',
            'photo_ktp' => null,
            'username' => 'admin',
            'email' => 'admin@casafunds.com',
            'password' => bcrypt('123123123'),
            'role' => 'admin',
            'status' => 'tetap',
            'is_married' => true,
        ]);

        $categories = [
            'Perbaikan Jalan',
            'Perbaikan Selokan',
            'Lainnya'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
