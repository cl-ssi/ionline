<?php

namespace Database\Seeders;

use App\Models\Drugs\Reception;
use App\Models\Drugs\ReceptionItem;
use Illuminate\Database\Seeder;

class ReceptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recepction = Reception::Create([
            'parte'=>456,
            'parte_label' => 'Parte',
            'parte_police_unit_id'=>1,
            'document_number'=>123,
            'document_police_unit_id'=>2,
            'document_date'=>'2018-08-06',
            'delivery'=>'Alvaro Torres',
            'delivery_run'=>'15.287.582-7',
            'delivery_position'=>'Cabo 1°',
            'court_id'=>2,
            'imputed'=> 'Perico Perez Malandra',
            'imputed_run'=> '12.345.678-9',
            'observation'=>'Sin observacion',
            'user_id' => 12345678,
            'manager_id' => 12345678,
            'lawyer_id' => 12345678
        ]);

        $item = ReceptionItem::Create([
            'description'=> "Vieintinueve cuerpos ovoidales cubiertos de alusa transsparente más nylon negro conetenedores de polvo compacto beige",
            'substance_id'=> 4,
            'nue'=> '4226477',
            'sample_number'=> 1,
            'document_weight'=> 1.22,
            'gross_weight'=> 1.23,
            'net_weight'=> 1.02,
            'sample'=> 0.5,
            'countersample'=> 0.5,
            'destruct'=> 0.02,
            'equivalent'=> NULL,
            'reception_id'=>1
        ]);

        $item = ReceptionItem::Create([
            'description'=> "40 Cuerpos ovoidales cubiertos de alusa transparenta más nulon negro contenedores de polvo compacto beige",
            'substance_id'=> 10,
            'nue'=> '5095286',
            'sample_number'=> 1,
            'document_weight'=> 2.42,
            'gross_weight'=> 2.43,
            'net_weight'=> 2.00,
            'sample'=> 0.5,
            'countersample'=> 0.5,
            'destruct'=> 1.00,
            'equivalent'=> NULL,
            'reception_id'=>1
        ]);
    }
}
