<?php

use App\Models\Welfare\Benefits\Subsidy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignId('benefit_id')->constrained('well_bnf_benefits')->onDelete('cascade');
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('annual_cap')->nullable();
            $table->boolean('payment_in_installments');
            $table->text('recipient')->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });

        // prestaciones médicas

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'CONSULTAS MEDICAS Y PSIQUIATRICAS',
            'description'             => '* Consultas médicas 100% del arancel fonasa. * Consulta psiquiátrica hasta $20.000.- por evento - Tope anual',
            'annual_cap'              => 100000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'MEDICAMENTOS',
            'description'             => '80% del valor hasta un tope de $15.000.- por medicamento - Tope anual',
            'annual_cap'              => 140000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'INSUMOS',
            'description'             => '50% del valor del insumo - Tope anual',
            'annual_cap'              => 40000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'EXAMENES LABORATORIO',
            'description'             => '* Con código 150% de lo que indica la bonificación arancel fonasa.*Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap'              => 40000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'EXAMENES DE RAYOS',
            'description'             => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap'              => 60000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'EXAMENES ESPECIALIZADOS',
            'description'             => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap'              => 100000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'EXAMENES HISPATOLOGICOS',
            'description'             => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 70% del valor del bono - Tope anual',
            'annual_cap'              => 60000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'INTERVENCION QUIRURGICA',
            'description'             => '100% - Tope anual',
            'annual_cap'              => 160000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'HOSPITALIZACION',
            'description'             => '50% del valor - Tope anual',
            'annual_cap'              => 90000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'ATENCION OBSTETRICA',
            'description'             => '50% del código principal - Tope anual',
            'annual_cap'              => 80000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'TRATAMIENTOS ESPECIALIZADOS',
            'description'             => '* Con código 150% de lo que indica la bonificación arancel fonasa *Sin código Fonasa 50% del valor del bono - Tope anual',
            'annual_cap'              => 80000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'ATENCION ODONTOLOGICAS',
            'description'             => '100% $100.000 por imponente $80.000 por las cargas en total - Tope anual',
            'annual_cap'              => 180000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'ANTEOJOS Y LENTES CONTACTO OPTICOS : BLANCOS, FOTOCROMATICOS, BIFOCAL Y MULTIFOCAL',
            'description'             => '100% $80.000.- por imponente $60.000 por las cargas en total - Tope anual',
            'annual_cap'              => 140000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'APARATOS ORTOPEDICOS , PANTIS Y AUDIFONOS.',
            'description'             => '100% - Tope anual',
            'annual_cap'              => 50000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        Subsidy::create([
            'benefit_id'              => 1,
            'name'                    => 'ATENCION DE URGENCIA.',
            'description'             => '100% - Tope anual',
            'annual_cap'              => 40000,
            'payment_in_installments' => false,
            'recipient'               => null,
        ]);

        // subsidios

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'MATRIMONIO',
            'description'             => '$150.000.-',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'NACIMIENTO',
            'description'             => '$170.000.-',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'FALLECIMIENTO',
            'description'             => '$500.000.-',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente y cargas familiares',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'INCENDIO Y/O CATASTROFE',
            'description'             => '$ 200.000.-',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'EDUCACION - PRE-KINDER',
            'description'             => '$35.000.- TOPE $160.000.',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente y cargas familiares.',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'EDUCACION - KINDER',
            'description'             => '$40.000.- TOPE $160.000.',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente y cargas familiares.',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'EDUCACION - BASICA',
            'description'             => '$45.000.- TOPE $160.000.',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente y cargas familiares.',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'EDUCACION - MEDIA',
            'description'             => '$50.000.- TOPE $160.000.',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente y cargas familiares.',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'EDUCACION - SUPERIOR',
            'description'             => '$80.000.- TOPE $160.000.',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente y cargas familiares.',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'BECAS PARA SOCIOS CON BECAS DE EXCELENCIA ACADEMICA EN NIVEL SUPERIOR',
            'description'             => '$65.000.-mensual por 10 meses.',
            'annual_cap'              => 650000,
            'payment_in_installments' => false,
            'recipient'               => 'Socios',
        ]);

        Subsidy::create([
            'benefit_id'              => 2,
            'name'                    => 'BONO NAVIDAD',
            'description'             => '$140.000.-',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
        ]);

        // prestamos

        Subsidy::create([
            'benefit_id'              => 3,
            'name'                    => 'PRESTAMO MEDICO',
            'description'             => '$530.000 Aprox. Hasta en 12 cuotas',
            'annual_cap'              => null,
            'payment_in_installments' => true,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 3,
            'name'                    => 'PRESTAMO AUXILIO',
            'description'             => '$260.000 Aprox. hasta en 12 cuotas',
            'annual_cap'              => null,
            'payment_in_installments' => true,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 3,
            'name'                    => 'PRESTAMO HABITACIONAL PARA: Compra de vivienda',
            'description'             => '$1.300.000.- Aprox. Hasta 36 cuotas.',
            'annual_cap'              => null,
            'payment_in_installments' => true,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 3,
            'name'                    => 'PRESTAMO HABITACIONAL PARA: Construcción, ampliación, reparación o témino de vivienda.',
            'description'             => '$1.300.000.- Aprox. Hasta 36 cuotas.',
            'annual_cap'              => null,
            'payment_in_installments' => true,
            'recipient'               => 'Imponente',
        ]);

        // cabañas de descanzo

        Subsidy::create([
            'benefit_id'              => 4,
            'name'                    => 'CABAÑA DE PICA GRANDE',
            'description'             => '$25.000 por noche',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 4,
            'name'                    => 'CABAÑA DE PICA PEQUEÑA',
            'description'             => '$20.000 por noche',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
        ]);

        Subsidy::create([
            'benefit_id'              => 4,
            'name'                    => 'CABAÑA CALETA RIO SECO',
            'description'             => '$15.000 por noche',
            'annual_cap'              => null,
            'payment_in_installments' => false,
            'recipient'               => 'Imponente',
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
