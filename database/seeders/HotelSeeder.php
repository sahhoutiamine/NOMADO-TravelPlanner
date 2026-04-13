<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('hotels')->truncate();
        Schema::enableForeignKeyConstraints();

        // Fill with your data
        // Each entry: ['city_id' => ?, 'name' => '', 'price_per_night' => 0, 'description' => '', 'image' => '']
        $hotels = [];

        if (!empty($hotels)) {
            DB::table('hotels')->insert($hotels);
        }
    }
}
