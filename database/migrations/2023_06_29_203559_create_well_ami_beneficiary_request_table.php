<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWellAmiBeneficiaryRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('well_ami_beneficiary_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_jefatura')->nullable();
            $table->string('cargo_unidad_departamento')->nullable();
            $table->string('correo_jefatura')->nullable();
            $table->string('motivo_requerimiento')->nullable();
            $table->string('nombre_funcionario_reemplazar')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('rut_funcionario')->nullable();
            $table->string('donde_cumplira_funciones')->nullable();
            $table->string('correo_personal')->nullable();
            $table->string('celular')->nullable();
            $table->date('fecha_inicio_contrato')->nullable();
            $table->date('fecha_termino_contrato')->nullable();
            $table->string('jornada_laboral')->nullable();
            $table->string('residencia')->nullable();
            $table->string('ha_utilizado_amipass')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('establecimiento')->nullable();
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
        Schema::dropIfExists('well_ami_beneficiary_requests');
    }
}
