<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\PurchaseMechanism;

class PurchaseMechanismSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseMechanism::Create(['name'=>'MENORES A 3 UTM']);
        PurchaseMechanism::Create(['name'=>'CONVENIO MARCO']);
        PurchaseMechanism::Create(['name'=>'TRATO DIRECTO']);
        PurchaseMechanism::Create(['name'=>'LICITACIÓN PÚBLICA']);
        PurchaseMechanism::Create(['name'=>'COMPRA ÁGIL (TRATO DIRECTO)']);
    }
}
