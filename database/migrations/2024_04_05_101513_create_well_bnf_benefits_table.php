<?php

use App\Models\Welfare\Benefits\Benefit;
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
        Schema::create('well_bnf_benefits', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Benefit::create([
            'name'        => 'PRESTACIONES MEDICAS',
            'observation' => 'DERECHO AL PRIMER MES DE COTIZACION*Compras en el extranjero con boleta o factura (solo documentos legales, no se aceptan recibos ni vales).',
        ]);

        Benefit::create([
            'name'        => 'SUBSIDIOS',
            'observation' => null,
        ]);

        Benefit::create([
            'name'        => 'PRESTAMOS',
            'observation' => 'IMPORTANTE: *Para solicitud de los préstamos, los avales deben presentar copia de Carnet de Identidad por ambos lados. *Préstamos sujetos al alcance financiero del 15% de liquidación según Ley.*No poseer préstamo vigente del mismo tipo al solicitado.*Préstamos Médico y Auxilio 3 meses de cotización como socio.*Préstamo Habitacional 1 año de cotización como socio.',
        ]);

        Benefit::create([
            'name'        => 'CABAÑAS DE DESCANSO',
            'observation' => 'Derecho al primer mes de cotización.- ES RESPONSABILIDAD DE CADA SOCIA Y SOCIO EL VERIFICAR EN SUS LIQUIDACIONES QUE SE ESTE REALIZANDO LOS DESCUENTOS CORRESPONDIENTES A BIENESTAR.',
        ]);

        // Benefit::create([
        //     'name' => 'CONVENIOS',
        //     'observation' => null
        // ]);

        // Benefit::create([
        //     'name' => 'OTROS BENEFICIOS (Actividades según presupuesto)',
        //     'observation' => null
        // ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_bnf_benefits');
    }
};
