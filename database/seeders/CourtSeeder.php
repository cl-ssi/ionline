<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Drugs\Court;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $court = Court::Create(['name'=>'Fiscalía Local de Iquique','address'=>'Bulnes 445', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía Local de Alto Hospicio','address'=>'Av Los Aromos 3889', 'commune'=>'Alto Hospicio','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía Local de Pozo Almonte','address'=>'Marcelo Dragoni 108', 'commune'=>'Pozo Almonte','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalia Militar Letrada de Iquique','address'=>'', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Tribunales de Familia','address'=>'', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Juzgado de Garantía de Iquique','address'=>'', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía Militar de Iquique','address'=>'SERRANO', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Juzgado De Familia Iquique','address'=>'Iquique', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Tribunal De Familia De Alto Hospicio','address'=>'Alto Hospicio', 'commune'=>'Alto Hospicio','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía Regional Metropolitana Sur','address'=>'SANTIAGO', 'commune'=>'Santiago','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía Naval - Cuarta Zona','address'=>'ARTURO PRAT 0101', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía De Aviación De Iquique','address'=>'', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Tribunal De Familia Iquique','address'=>'SERRANO', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Fiscalía Regional de Tarapacá','address'=>'BULNES 445', 'commune'=>'Iquique','status'=>1]);
        $court = Court::Create(['name'=>'Juzgado De Familia De Pozo Almonte','address'=>'Pozo Almonte', 'commune'=>'Pozo Almonte','status'=>1]);
        $court = Court::Create(['name'=>'Juzgado De Familia De Pozo Almonte','address'=>'Pozo Almonte', 'commune'=>'Pozo Almonte','status'=>1]);

    }
}
