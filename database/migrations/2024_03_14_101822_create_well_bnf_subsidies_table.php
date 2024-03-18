<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Welfare\Benefits\Subsidy;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('well_bnf_subsidies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('benefit_id')->constrained('well_bnf_benefits');
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('annual_cap')->nullable();
            $table->text('recipient')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // prestaciones médicas

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'CONSULTAS MEDICAS Y PSIQUIATRICAS',
            // 'percentage' => '* Consultas médicas 100% del arancel fonasa. * Consulta psiquiátrica hasta $20.000.- por evento.',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '100000',
            'description' => '* Consultas médicas 100% del arancel fonasa. * Consulta psiquiátrica hasta $20.000.- por evento - Tope anual',
            'annual_cap' => 100000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'MEDICAMENTOS',
            // 'percentage' => '80% del valor hasta un tope de $15.000.- por medicamento',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '140000',
            'description' => '80% del valor hasta un tope de $15.000.- por medicamento - Tope anual',
            'annual_cap' => 140000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'INSUMOS',
            // 'percentage' => '50% del valor del insumo.',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '40000',
            'description' => '50% del valor del insumo - Tope anual',
            'annual_cap' => 40000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'EXAMENES LABORATORIO',
            // 'percentage' => '* Con código 150% de lo que indica la bonificación arancel fonasa.*Sin código Fonasa 70% del valor del bono',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '40000',
            'description' => '* Con código 150% de lo que indica la bonificación arancel fonasa.*Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap' => 40000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'EXAMENES DE RAYOS',
            // 'percentage' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '60000',
            'description' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap' => 60000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'EXAMENES ESPECIALIZADOS',
            // 'percentage' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '100000',
            'description' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap' => 100000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'EXAMENES HISPATOLOGICOS',
            // 'percentage' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '60000',
            'description' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap' => 60000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'INTERVENCION QUIRURGICA',
            // 'percentage' => '100%',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '160000',
            'description' => '100% - Tope anual',
            'annual_cap' => 160000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'HOSPITALIZACION',
            // 'percentage' => '50% del valor',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '90000',
            'description' => '50% del valor - Tope anual',
            'annual_cap' => 90000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'ATENCION OBSTETRICA',
            // 'percentage' => '50% del código principal',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '80000',
            'description' => '50% del código principal - Tope anual',
            'annual_cap' => 80000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'TRATAMIENTOS ESPECIALIZADOS',
            // 'percentage' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 50% del valor del bono',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '80000',
            'description' => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 50% del valor del bono - Tope anual',
            'annual_cap' => 80000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'ATENCION ODONTOLOGICAS',
            // 'percentage' => '100% $100.000 por imponente $80.000 por las cargas en total',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '180000',
            'description' => '100% $100.000 por imponente $80.000 por las cargas en total - Tope anual',
            'annual_cap' => 180000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'ANTEOJOS Y LENTES CONTACTO OPTICOS : BLANCOS, FOTOCROMATICOS, BIFOCAL Y MULTIFOCAL',
            // 'percentage' => '100% $80.000.- por imponente $60.000 por las cargas en total',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '140000',
            'description' => '100% $80.000.- por imponente $60.000 por las cargas en total - Tope anual',
            'annual_cap' => 140000,
            'recipient' => null
        ]);


        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'APARATOS ORTOPEDICOS , PANTIS Y AUDIFONOS.',
            // 'percentage' => '100%',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '50000',
            'description' => '100% - Tope anual',
            'annual_cap' => 50000,
            'recipient' => null
        ]);

        Subsidy::create([
            'benefit_id' => 1,
            'name' => 'ATENCION DE URGENCIA.',
            // 'percentage' => '100%',
            // 'type' => 'TOPE ANUAL TOTAL $',
            // 'value' => '40000',
            'description' => '100% - Tope anual',
            'annual_cap' => 40000,
            'recipient' => null
        ]);

        // subsidios

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'MATRIMONIO',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '170000',
            'description' => 'Monto',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'NACIMIENTO',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '150000',
            'description' => 'Monto',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'FALLECIMIENTO',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '500000',
            'description' => 'Monto',
            'annual_cap' => null,
            'recipient' => 'Imponente y cargas familiares'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'INCENDIO Y/O CATASTROFE',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '200000',
            'description' => 'Monto',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'EDUCACION - PRE-KINDER',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '35000',
            'description' => 'Monto',
            'annual_cap' => null,
            'recipient' => 'TOPE $160.000.-Entre imponente y cargas familiares.'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'EDUCACION - KINDER',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '40000',
            'description' => 'Monto',
            'annual_cap' => 160000,
            'recipient' => 'TOPE $160.000.-Entre imponente y cargas familiares.'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'EDUCACION - BASICA',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '45000',
            'description' => 'Monto',
            'annual_cap' => 160000,
            'recipient' => 'TOPE $160.000.-Entre imponente y cargas familiares.'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'EDUCACION - MEDIA',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '50000',
            'description' => 'Monto',
            'annual_cap' => 160000,
            'recipient' => 'TOPE $160.000.-Entre imponente y cargas familiares.'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'EDUCACION - SUPERIOR',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '55000',
            'description' => 'Monto',
            'annual_cap' => 160000,
            'recipient' => 'TOPE $160.000.-Entre imponente y cargas familiares.'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'BECAS PARA SOCIOS CON BECAS DE EXCELENCIA ACADEMICA EN NIVEL SUPERIOR',
            // 'percentage' => null,
            // 'type' => 'MONTO MENSUAL POR 10 MESES',
            // 'value' => '65000',
            'description' => 'Monto',
            'annual_cap' => 650000,
            'recipient' => 'TOPE$ 650.000.-'
        ]);

        Subsidy::create([
            'benefit_id' => 2,
            'name' => 'BONO NAVIDAD',
            // 'percentage' => null,
            // 'type' => 'MONTO',
            // 'value' => '140000',
            'description' => 'Monto',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        // prestamos

        Subsidy::create([
            'benefit_id' => 3,
            'name' => 'PRESTAMO MEDICO',
            // 'percentage' => null,
            // 'type' => 'MONTO Aprox. Hasta en 12 cuotas',
            // 'value' => '530000',
            'description' => 'Monto Aprox. Hasta en 12 cuotas',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 3,
            'name' => 'PRESTAMO AUXILIO',
            // 'percentage' => null,
            // 'type' => 'MONTO Aprox. Hasta en 12 cuotas',
            // 'value' => '260000',
            'description' => 'Monto Aprox. Hasta en 12 cuotas',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 3,
            'name' => 'PRESTAMO HABITACIONAL PARA: Compra de vivienda',
            // 'percentage' => null,
            // 'type' => 'MONTO Aprox. Hasta 36 cuotas.',
            // 'value' => '1300000',
            'description' => 'Monto Aprox. Hasta en 36 cuotas',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 3,
            'name' => 'PRESTAMO HABITACIONAL PARA: Construcción, ampliación, reparación o témino de vivienda.',
            // 'percentage' => null,
            // 'type' => 'MONTO Aprox. Hasta 36 cuotas.',
            // 'value' => '1300000',
            'description' => 'Monto Aprox. Hasta en 36 cuotas',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        // cabañas de descanzo

        Subsidy::create([
            'benefit_id' => 4,
            'name' => 'CABAÑA DE PICA GRANDE',
            // 'percentage' => null,
            // 'type' => 'VALOR',
            // 'value' => '25000',
            'description' => 'Valor',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 4,
            'name' => 'CABAÑA DE PICA PEQUEÑA',
            // 'percentage' => null,
            // 'type' => 'VALOR',
            // 'value' => '20000',
            'description' => 'Valor',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

        Subsidy::create([
            'benefit_id' => 4,
            'name' => 'CABAÑA CALETA RIO SECO',
            // 'percentage' => null,
            // 'type' => 'VALOR',
            // 'value' => '15000',
            'description' => 'Valor',
            'annual_cap' => null,
            'recipient' => 'Imponente'
        ]);

    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_bnf_subsidies');
    }
};
