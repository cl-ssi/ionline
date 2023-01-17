<?php

namespace Database\Seeders;

use App\Models\Parameters\EstablishmentType;
use Illuminate\Database\Seeder;

class EstablishmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        
        EstablishmentType::Create(['name'=>'CECOSF']);
        EstablishmentType::Create(['name'=>'CESFAM']);
        EstablishmentType::Create(['name'=>'CGR']);
        EstablishmentType::Create(['name'=>'COSAM']);
        EstablishmentType::Create(['name'=>'HOSPITAL']);
        EstablishmentType::Create(['name'=>'PRAIS']);
        EstablishmentType::Create(['name'=>'PSR']);
        EstablishmentType::Create(['name'=>'SAPU']);

    }
}
