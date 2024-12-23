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
        Schema::create('well_ami_abscences', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->nullable();
            $table->string('dv')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ley')->nullable();
            $table->integer('edad_años')->nullable();
            $table->integer('edad_meses')->nullable();
            $table->string('afp')->nullable();
            $table->string('salud')->nullable();
            $table->integer('codigo_unidad')->nullable();
            $table->string('nombre_unidad')->nullable();
            $table->string('genero')->nullable();
            $table->string('cargo')->nullable();
            $table->string('calidad_juridica')->nullable();
            $table->string('planta')->nullable();
            $table->string('nro_resolucion')->nullable();
            $table->date('fecha_resolucion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->integer('total_dias_auscentismo')->nullable();
            $table->integer('auscentismo_en_el_periodo')->nullable();
            $table->bigInteger('costo_de_licencia')->nullable();
            $table->string('tipo_de_auscentismo')->nullable();
            $table->integer('codigo_de_establecimiento')->nullable();
            $table->string('nombre_de_establecimiento')->nullable();
            $table->integer('saldo_dias_no_reemplazados')->nullable();
            $table->string('tipo_de_contrato')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_ami_abscences');
    }
};
