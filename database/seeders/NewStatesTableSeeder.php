<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            [
                'country_id' => 1,
                'name' => 'Alajuela',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'name' => 'Cartago',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'name' => 'Heredia',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'name' => 'Guanacaste',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'name' => 'Puntarenas',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'name' => 'Limón',
                'is_active' => true,
            ],
        ]);
    }
}
