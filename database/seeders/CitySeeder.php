<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cities')->truncate();
        Schema::enableForeignKeyConstraints();

        // Fill with your data
        // Each entry: ['country_id' => ?, 'name' => '', 'trip_type' => '', 'description' => '', 'image' => '']
        $cities = [];

        if (!empty($cities)) {
            DB::table('cities')->insert($cities);
        }
    }
}
