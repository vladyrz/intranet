<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'name' => 'Costa Rica',
                'iso2' => 'CR',
                'iso3' => 'CRI',
                'numeric_code' => '188',
                'phonecode' => '506',
                'capital' => 'San José',
                'currency' => 'CRC',
                'currency_name' => 'Costa Rican colón',
                'currency_symbol' => '₡',
                'tld' => '.cr',
                'native' => 'Costa Rica',
                'region' => 'Americas',
                'subregion' => 'Central America',
                'timezones' => json_encode([
                    [
                        'zoneName' => 'America/Costa_Rica',
                        'gmtOffset' => -21600,
                        'gmtOffsetName' => 'UTC-06:00',
                        'abbreviation' => 'CST',
                        'tzName' => 'Central Standard Time'
                    ]
                ]),
                'translations' => json_encode([
                    'es' => 'Costa Rica',
                    'fr' => 'Costa Rica'
                ]),
                'latitude' => 9.748917,
                'longitude' => -83.753428,
                'emoji' => '🇨🇷',
                'emojiU' => 'U+1F1E8 U+1F1F7',
                'flag' => true,
                'is_active' => true,
            ],
        ]);
    }
}
