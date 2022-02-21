<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\PurchaseUnit;

class PurchaseUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseUnit::Create(['name'=>'Bienes y servicios']);
        PurchaseUnit::Create(['name'=>'Administración de Fondos']);
        PurchaseUnit::Create(['name'=>'Compra Conjuntas']);
        PurchaseUnit::Create(['name'=>'Compras Convenios Gore']);
        PurchaseUnit::Create(['name'=>'Fármacos']);
        PurchaseUnit::Create(['name'=>'Hospital Dr Hector Reyno G.']);
        PurchaseUnit::Create(['name'=>'Obras Civiles']);
        PurchaseUnit::Create(['name'=>'Servicio Bienestar']);
        PurchaseUnit::Create(['name'=>'Servicio de Salud Iquique']);
    }
}
