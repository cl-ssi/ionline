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
        Schema::create('rrhh_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->nullable();
            $table->string('dv')->nullable();
            $table->integer('correlativo')->nullable();
            $table->string('nombre_funcionario')->nullable();
            $table->integer('codigo_planta')->nullable();
            $table->string('descripcion_planta')->nullable();
            $table->integer('codigo_calidad_juridica')->nullable();
            $table->string('descripcion_calidad_juridica')->nullable();
            $table->string('grado')->nullable();
            $table->string('genero')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('comuna')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->date('fecha_ingreso_grado')->nullable();
            $table->date('fecha_ingreso_servicio')->nullable();
            $table->date('fecha_ingreso_adm_publica')->nullable();
            $table->string('codigo_isapre')->nullable();
            $table->string('descripcion_isapre')->nullable();
            $table->string('codigo_afp')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('cargas_familiares')->nullable();
            $table->string('bieniotrienio')->nullable();
            $table->string('antiguedad')->nullable();
            $table->string('ley')->nullable();
            $table->string('numero_horas')->nullable();
            $table->string('etapa')->nullable();
            $table->string('nivel')->nullable();
            $table->date('fecha_inicio_en_el_nivel')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('antiguedad_en_nivel_anosmesesdias')->nullable();
            $table->string('establecimiento')->nullable();
            $table->string('descripcion_establecimiento')->nullable();
            $table->string('glosa_establecimiento_9999_contratos_historicos')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('codigo_unidad')->nullable();
            $table->string('descripcion_unidad')->nullable();
            $table->integer('codigo_unidad_2')->nullable();
            $table->string('descripcion_unidad_2')->nullable();
            $table->string('c_costo')->nullable();
            $table->string('codigo_turno')->nullable();
            $table->integer('codigo_cargo')->nullable();
            $table->string('descripcion_cargo')->nullable();
            $table->integer('correl_informe')->nullable();
            $table->integer('codigo_funcion')->nullable();
            $table->string('descripcion_funcion')->nullable();
            $table->string('especcarrera')->nullable();
            $table->string('titulo')->nullable();
            $table->date('fecha_inicio_contrato')->nullable();
            $table->date('fecha_termino_contrato')->nullable();
            $table->date('fecha_alejamiento')->nullable();
            $table->integer('correl_planta')->nullable();
            $table->string('15076condicion')->nullable();
            $table->string('transitorio')->nullable();
            $table->string('numero_resolucion')->nullable();
            $table->date('fecha_resolucion')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('tipo_movimiento')->nullable();
            $table->string('total_haberes')->nullable();
            $table->string('remuneracion')->nullable();
            $table->string('sin_planillar')->nullable();
            $table->string('servicio_de_salud')->nullable();
            $table->string('usuario_ingreso')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('rut_del_reemplazado')->nullable();
            $table->string('dv_del_reemplazado')->nullable();
            $table->integer('corr_contrato_del_reemplazado')->nullable();
            $table->string('nombre_del_reemplazado')->nullable();
            $table->string('motivo_del_reemplazo')->nullable();
            $table->date('fecha_inicio_ausentismo')->nullable();
            $table->date('fecha_termino_ausentismo')->nullable();
            $table->date('fecha_primer_contrato')->nullable();
            $table->boolean('shift')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['rut', 'correlativo'], 'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_contracts');
    }
};
