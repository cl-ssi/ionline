<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\PurchaseType;

class PurchaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseType::Create(['name'=>'FONDO MENOR (CAJA CHICA)',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>2,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'OC INTERNA',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>14,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'FONDO A RENDIR',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>30,
                              'year'=>2021]);

        PurchaseType::Create(['name'=>'CONVENIO MARCO MENOR A 1.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>14,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'GRAN COMPRA > 1.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>60,
                              'year'=>2021]);

        PurchaseType::Create(['name'=>'COMPRA SUMINISTRO VIGENTE BIENES Y SERVICIOS',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>5,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'COMPRA AGIL MENOR A 30 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>14,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'TRATO DIRECTO MAYOR A 30 Y MENOR A 1.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>21,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'TRATO DIRECTO MAYOR A 1.000 Y MENOR A 5.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>30,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'TRATO DIRECTO BIENES Y SERVICIOS MAYOR A 5.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>60,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'TRATO DIRECTO OBRAS MAYORES A 10.00 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>60,
                              'year'=>2021]);

        // PurchaseType::Create(['name'=>'COMPRA SUMINISTRO VIGENTE BIENES Y SERVICIOS',
        //                       'finance_business_day'=>2,
        //                       'supply_continuous_day'=>5,
        //                       'year'=>2021]);
        
        PurchaseType::Create(['name'=>'L1 de 10 A 100 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>25,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'LE de 100 A 1.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>45,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'LP de 1.000 A 1.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>60,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'LQ de 2.000 A 5.000 UTM',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>60,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'LR MAYOR A 5.000 MENOR A 8.000 UTM BIENES Y SERVICIOS',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>90,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'LR MAYOR A 8.000 UTM BIENES Y SERVICIOS',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>120,
                              'year'=>2021]);
        PurchaseType::Create(['name'=>'LR MAYOR A 15.000 UTM OBRAS',
                              'finance_business_day'=>2,
                              'supply_continuous_day'=>120,
                              'year'=>2021]);
    }
}
