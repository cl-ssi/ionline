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
        Schema::create('well_ami_beneficiary_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_jefatura')->nullable();
            $table->string('cargo_unidad_departamento')->nullable();
            $table->string('correo_jefatura')->nullable();
            $table->string('motivo_requerimiento')->nullable();
            $table->string('nombre_funcionario_reemplazar')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('rut_funcionario')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('donde_cumplira_funciones')->nullable();
            $table->string('correo_personal')->nullable();
            $table->string('celular')->nullable();
            $table->date('fecha_inicio_contrato');
            $table->string('fecha_termino_contrato');
            $table->string('jornada_laboral')->nullable();
            $table->string('residencia')->nullable();
            $table->string('ha_utilizado_amipass')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('establecimiento')->nullable();
            $table->string('historial')->nullable();
            $table->string('estado')->nullable();
            $table->foreignId('ami_manager_id')->nullable()->constrained('users');
            $table->datetime('ami_manager_at')->nullable();
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
        Schema::dropIfExists('well_ami_beneficiary_requests');
    }
};
