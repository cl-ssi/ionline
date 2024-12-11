<?php

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
        Schema::create('rrhh_absenteeisms', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->nullable();
            $table->string('dv')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ley')->nullable();
            $table->integer('edadanos')->nullable();
            $table->integer('edadmeses')->nullable();
            $table->string('afp')->nullable();
            $table->string('salud')->nullable();
            $table->integer('codigo_unidad')->nullable();
            $table->string('nombre_unidad')->nullable();
            $table->string('genero')->nullable();
            $table->string('cargo')->nullable();
            $table->string('calidad_juridica')->nullable();
            $table->string('planta')->nullable();
            $table->string('n_resolucion')->nullable();
            $table->date('fresolucion')->nullable();
            $table->date('finicio')->nullable();
            $table->date('ftermino')->nullable();
            $table->integer('total_dias_ausentismo')->nullable();
            $table->integer('ausentismo_en_el_periodo')->nullable();
            $table->bigInteger('costo_de_licencia')->nullable();
            $table->string('tipo_de_ausentismo')->nullable();
            $table->foreignId('absenteeism_type_id')->nullable()->constrained('rrhh_absenteeism_types');
            $table->integer('codigo_de_establecimiento')->nullable();
            $table->string('nombre_de_establecimiento')->nullable();
            $table->integer('saldo_dias_no_reemplazados')->nullable();
            $table->string('tipo_de_contrato')->nullable();
            $table->string('jornada', 2)->nullable();
            $table->string('observacion')->nullable();
            $table->dateTime('sirh_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unique(['rut', 'finicio', 'ftermino', 'absenteeism_type_id'], 'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_absenteeisms');
    }
};
