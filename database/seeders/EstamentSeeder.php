<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\Estament;

class EstamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estament::create([
            'category' => 'A', 
            'name' => 'Médicos/Químico Farmacéuticos/Odontólogos'
        ]);
        Estament::create([
            'category' => 'B', 
            'name' => 'Otros profesionales'
        ]);
        Estament::create([
            'category' => 'C', 
            'name' => 'Técnicos de nivel superior'
        ]);
        Estament::create([
            'category' => 'D', 
            'name' => 'Técnicos de nivel medio'
        ]);
        Estament::create([
            'category' => 'E', 
            'name' => 'Administrativos'
        ]);
        Estament::create([
            'category' => 'F', 
            'name' => 'Choferes/Serenos'
        ]);
    }
}
