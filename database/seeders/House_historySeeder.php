<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\House_history;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class House_historySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $houses = House::all();
        $users = User::all();

        foreach ($houses as $house) {
            House_history::create([
                'house_id' => $house->id,
                'user_id' => $users->random()->id,
                'start_date' => now()->subDays(rand(1, 30)),
                'end_date' => null,
            ]);
        }
    }
}
