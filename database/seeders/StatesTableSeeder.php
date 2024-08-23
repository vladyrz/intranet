<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            [
                'country_id' => 1,
                'name' => 'San José',
                'latitude' => 9.928069,
                'longitude' => -84.090725,
                'is_active' => true,
            ],
        ]);
    }
}
