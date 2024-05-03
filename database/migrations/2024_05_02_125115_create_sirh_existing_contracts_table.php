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
        Schema::create('sirh_existing_contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('rut');
            $table->string('dv');
            $table->integer('corr');
            $table->string('nombres');
            $table->date('fecha');
            $table->string('ley_afecto');
            $table->string('calidad_juridica');
            $table->string('planta');
            $table->integer('unidad')->nullable();
            $table->string('unid_descripcion')->nullable();
            $table->integer('grado')->nullable();
            $table->integer('hora_semana');
            $table->integer('codigo_esta');
            $table->string('esta_nombre');
            $table->date('fecha_ini');
            $table->date('fecha_fin')->nullable();
            $table->string('cod_cargo');
            $table->string('carg_nombre');
            $table->integer('num_docu');
            $table->string('tipo_documento');
            $table->date('fecha_resolucion');
            $table->integer('cod_funcion');
            $table->string('funcion');
            $table->string('etapa_carrera')->nullable();
            $table->string('nivel_etapa')->nullable();
            $table->integer('movi_planta');
            $table->string('tipo_movimiento');
            $table->string('transitorio');
            $table->string('lib_guardia');
            $table->date('fecha_nacimiento');
            $table->string('lugar_de_nacimiento')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('sexo')->nullable();
            $table->string('direccion')->nullable();
            $table->string('comuna')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('fono')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sirh_existing_contracts');
    }
};
