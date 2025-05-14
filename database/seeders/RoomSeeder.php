<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'number' => 'Room 1',
            'type' => 'Single',
            'price_per_night' => 100,
            'is_available' => true,
        ]);
        Room::create([
            'number' => 'Room 2',
            'type' => 'Double',
            'price_per_night' => 150,
            'is_available' => true,
        ]);
        Room::create([
            'number' => 'Room 3',
            'type' => 'Suite',
            'price_per_night' => 200,
            'is_available' => true,
        ]);
    }
}
