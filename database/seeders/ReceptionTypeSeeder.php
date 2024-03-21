<?php

namespace Database\Seeders;

use App\Models\Finance\Receptions\ReceptionType;
use Illuminate\Database\Seeder;

class ReceptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReceptionType::create([
            'name' => 'Bienes',
            'title' => 'Acta de recepción conforme',
            'establishment_id' => 38,
        ]);
        ReceptionType::create([
            'name' => 'Servicios',
            'title' => 'Informe de cumplimiento de servicios',
            'establishment_id' => 38,
        ]);
        ReceptionType::create([
            'name' => 'Obras',
            'title' => 'Acta de recepción conforme',
            'establishment_id' => 38,
        ]);


        ReceptionType::create([
            'name' => 'Bienes',
            'title' => 'Acta de recepción conforme',
            'establishment_id' => 41,
        ]);
        ReceptionType::create([
            'name' => 'Servicios',
            'title' => 'Informe de cumplimiento de servicios',
            'establishment_id' => 41,
        ]);
        ReceptionType::create([
            'name' => 'Obras',
            'title' => 'Acta de recepción conforme',
            'establishment_id' => 41,
        ]);


        ReceptionType::create([
            'name' => 'Bienes',
            'title' => 'Acta de recepción conforme',
            'establishment_id' => 1,
        ]);
        ReceptionType::create([
            'name' => 'Servicios',
            'title' => 'Informe de cumplimiento de servicios',
            'establishment_id' => 1,
        ]);
        ReceptionType::create([
            'name' => 'Obras',
            'title' => 'Acta de recepción conforme',
            'establishment_id' => 1,
        ]);
    }
}



