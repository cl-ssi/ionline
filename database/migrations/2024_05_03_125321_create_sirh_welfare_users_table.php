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
        Schema::create('sirh_welfare_users', function (Blueprint $table) {
            $table->id();
            $table->string('rut');
            $table->string('dv');
            $table->date('fecha');
            $table->string('nombre');
            $table->date('fecha_nac');
            $table->integer('edad');
            $table->string('sexo');
            $table->string('tipo_afilia');
            $table->string('vigencia');
            $table->string('direccion');
            $table->string('telefono')->nullable();
            $table->string('salud')->nullable();
            $table->string('prevision')->nullable();
            $table->string('contrato');
            $table->string('unidad')->nullable();
            $table->string('establ')->nullable();
            $table->string('cargo')->nullable();
            $table->decimal('cuota_mes', 10, 2);
            $table->date('afil_fecha_desafiliacion')->nullable();
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
        Schema::dropIfExists('sirh_welfare_users');
    }
};
