<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('places')->truncate();
        Schema::enableForeignKeyConstraints();

        // Fill with your data
        // Each entry: ['city_id' => ?, 'name' => '', 'description' => '', 'image' => '']
        $places = [];

        if (!empty($places)) {
            DB::table('places')->insert($places);
        }
    }
}
