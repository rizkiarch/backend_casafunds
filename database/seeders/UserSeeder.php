<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\House;
use App\Models\Category;
use App\Models\Spending;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\House_history;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 18; $i++) {
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

        User::create([
            'full_name' => 'User Warga',
            'phone_number' => '085216000522',
            'photo_ktp' => null,
            'username' => 'user',
            'email' => 'user@casafunds.com',
            'password' => bcrypt('123123123'),
            'role' => 'user',
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

        $this->HouseSeeder();
        $this->paymentSeeder();
        $this->spendingSeeder();
    }

    public function HouseSeeder()
    {
        $users = User::all();

        for ($j = 1; $j <= 20; $j++) {
            $status = ($j <= 15) ? 'Dihuni' : 'Kosong';
            if ($status == "Dihuni") {
                $house = House::create([
                    'address' => 'House Address ' . $j,
                    'status' => $status,
                    'user_id' => $users->random()->id,
                ]);
            } else {
                $house = House::create([
                    'address' => 'House Address ' . $j,
                    'status' => $status,
                    'user_id' => null,
                ]);
            }

            if ($status == 'Dihuni') {
                House_history::create([
                    'house_id' => $house->id,
                    'user_id' => $house->user_id,
                    'start_date' => now()->subDays(rand(1, 30)),
                    'end_date' => null,
                ]);
            }
        }
    }

    public function paymentSeeder()
    {
        $users = User::all();
        $houses = House::all();

        for ($i = 0; $i < 10; $i++) {
            $house = $houses->random();
            $user = $users->random();

            $iuran_kebersihan = rand(13000, 25000);
            $iuran_satpam = rand(90000, 200000);
            $is_paid = $iuran_kebersihan < 15000 || $iuran_satpam < 100000 ? false : true;
            $paid_at = $is_paid ? now()->subDays(rand(1, 30)) : null;

            Payment::create([
                'house_id' => $house->id,
                'user_id' => $user->id,
                'iuran_kebersihan' => $iuran_kebersihan,
                'iuran_satpam' => $iuran_satpam,
                'is_paid' => $is_paid,
                'payment_date' => now()->subDays(rand(1, 30)),
                'paid_at' => $paid_at,
            ]);
        }
    }

    public function spendingSeeder()
    {
        $categories = Category::all();

        for ($i = 0; $i < 10; $i++) {
            $category = $categories->random();

            Spending::create([
                'description' => 'Spending Description ' . $i,
                'category_id' => $category->id,
                'amount' => rand(100000, 1000000),
                'spending_date' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
