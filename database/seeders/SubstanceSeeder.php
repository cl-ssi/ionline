<?php

namespace Database\Seeders;

use App\Models\Drugs\Substance;
use Illuminate\Database\Seeder;

class SubstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* Sustancias Presuntas */
        $substance = Substance::Create(['name'=>'Sin Contenido','rama'=>NULL, 'unit'=>NULL, 'laboratory'=>NULL, 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Cigarrillo Hierba','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'SEREMI', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Cigarrillo Hierba-Polvo','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>TRUE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Cocaina','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>TRUE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Cocaina Liquida','rama'=>'Estimulantes', 'unit'=>'Mililitros', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Sustancia Desconocida','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>TRUE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Sustancia Liquida','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Estampilla','rama'=>'Alucinógenos', 'unit'=>'Unidades', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Hoja De Coca','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Marihuana','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'SEREMI', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Medicamento Molido','rama'=>NULL, 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>TRUE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Medicamento Polvo','rama'=>'Depresores', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Medicamento FF Entero','rama'=>'Estimulantes', 'unit'=>'Unidades', 'laboratory'=>'ISP', 'isp'=>TRUE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Mezcla Hierba-Polvo','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Planta','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'SEREMI', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Precursor Liquido','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Precursor Solido','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Semillas','rama'=>'Alucinógenos', 'unit'=>'Gramos', 'laboratory'=>'SEREMI', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Sustancia Pastosa','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>FALSE,'presumed'=>1]);
        $substance = Substance::Create(['name'=>'Tela Impregnada','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>'ISP', 'isp'=>TRUE,'presumed'=>1]);


        /* Sustancias encontradas */
        $substance = Substance::Create(['name'=>'No se detecto sustancia','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Marihuana','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Cocaina','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Cocaina Base','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Cocaina Clorhidrato','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Mezcla Cocaina/Hierba','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Mezcla Cocaina/Tabaco','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Clonazepam','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Lidocaina','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Dextrometorfano','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Flunitrazepam','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Diazepam','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Hoja de Coca','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Alprazolam','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Tabaco','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Carbamazepina','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Lorazepam','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Cocaina-Marihuana','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Medicamento-Marihuana','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Metilfenidato','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Éxtasis','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Anfetamina','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'LSD','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);
        $substance = Substance::Create(['name'=>'Midazolam','rama'=>'Estimulantes', 'unit'=>'Gramos', 'laboratory'=>NULL, 'isp'=>NULL,'presumed'=>0]);

    }
}
