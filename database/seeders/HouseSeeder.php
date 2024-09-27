<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\House_history;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
}
