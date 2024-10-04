<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            // Cantones de San José (state_id = 1)
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Escazú',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Desamparados',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Puriscal',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Tarrazú',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Aserrí',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Mora',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Goicoechea',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Santa Ana',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Alajuelita',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Vázquez de Coronado',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Acosta',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Tibás',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Moravia',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Montes de Oca',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Turrubares',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Dota',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Curridabat',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Pérez Zeledón',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'León Cortés',
                'is_active' => true,
            ],
            // Cantones de Alajuela (state_id = 2)
            [
                'country_id' => 1,
                'state_id' => 2, // ID de la provincia de Alajuela
                'name' => 'Alajuela',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'San Ramón',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Grecia',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Atenas',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Naranjo',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Palmares',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Poás',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Orotina',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'San Carlos',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Zarcero',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Valverde Vega',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Upala',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Los Chiles',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Guatuso',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Río Cuarto',
                'is_active' => true,
            ],
            // Cantones de Cartago (state_id = 3)
            [
                'country_id' => 1,
                'state_id' => 3, // ID de la provincia de Cartago
                'name' => 'Cartago',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'Paraíso',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'La Unión',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'Jiménez',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'Turrialba',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'Alvarado',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'Oreamuno',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 3,
                'name' => 'El Guarco',
                'is_active' => true,
            ],
            // Cantones de Heredia (state_id = 4)
            [
                'country_id' => 1,
                'state_id' => 4, // ID de la provincia de Heredia
                'name' => 'Heredia',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'Barva',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'Santo Domingo',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'Santa Bárbara',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'San Rafael',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'San Isidro',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'Belén',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'Flores',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'San Pablo',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 4,
                'name' => 'Sarapiquí',
                'is_active' => true,
            ],
            // Cantones de Guanacaste (state_id = 5)
            [
                'country_id' => 1,
                'state_id' => 5, // ID de la provincia de Guanacaste
                'name' => 'Liberia',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Nicoya',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Santa Cruz',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Bagaces',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Carrillo',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Cañas',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Abangares',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Tilarán',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Nandayure',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'La Cruz',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 5,
                'name' => 'Hojancha',
                'is_active' => true,
            ],
            // Cantones de Puntarenas (state_id = 6)
            [
                'country_id' => 1,
                'state_id' => 6, // ID de la provincia de Puntarenas
                'name' => 'Puntarenas',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Esparza',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Buenos Aires',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Montes de Oro',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Osa',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Quepos',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Golfito',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Coto Brus',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Parrita',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Corredores',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'Garabito',
                'is_active' => true,
            ],
            // Cantones de Limón (state_id = 7)
            [
                'country_id' => 1,
                'state_id' => 7, // ID de la provincia de Limón
                'name' => 'Limón',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 7,
                'name' => 'Pococí',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 7,
                'name' => 'Siquirres',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 7,
                'name' => 'Talamanca',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 7,
                'name' => 'Matina',
                'is_active' => true,
            ],
            [
                'country_id' => 1,
                'state_id' => 7,
                'name' => 'Guácimo',
                'is_active' => true,
            ],
        ]);
    }
}
