<?php

use Illuminate\Database\Seeder;
use App\Programmings\ActionType;

class ActionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActionType::Create(['name'=>'PREVENCION','alias'=>'PREVENCION']);
        ActionType::Create(['name'=>'TRATAMIENTO','alias'=>'TRATAMIENTO']);
        ActionType::Create(['name'=>'CUIDADOS PALIATIVOS','alias'=>'CUIDADOS PALIATIVOS']);
        ActionType::Create(['name'=>'REHABILITACION','alias'=>'REHABILITACION']);
        ActionType::Create(['name'=>'ATENCION DIAGNÓSTICA','alias'=>'ATENCION DIAGNÓSTICA']);
        ActionType::Create(['name'=>'COORDINACIÓN ENTRE NIVELES (para mayor integración)','alias'=>'COORDINACIÓN ENTRE NIVELES']);
    }
}
