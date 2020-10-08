<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProgrammingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_programming_days', function (Blueprint $table) {
            $table->id();
            $table->decimal('weekends',5,2)->nullable()->default('0'); // FINES DE SEMANA
            $table->decimal('national_holidays',5,2)->nullable()->default('0'); // DÍAS FERIADOS  
            $table->decimal('noon_estament',5,2)->nullable()->default('0'); // MEDIO DIA POR ESTAMENTO
            $table->decimal('noon_parties',5,2)->nullable()->default('0'); // MEDIO DIA POR FIESTAS (PATRIAS, NAVIDAD, AÑO NUEVO)
            $table->decimal('training',5,2)->nullable()->default('0'); // CAPACITACIÓN
            $table->decimal('holidays',5,2)->nullable()->default('0'); // VACACIONES
            $table->decimal('administrative_permits',5,2)->nullable()->default('0'); // PERMISOS ADMINISTRATIVOS
            $table->decimal('associations_lunches',5,2)->nullable()->default('0'); // ALMUERZOS DE ASOCIACIONES
            $table->decimal('others',5,2)->nullable()->default('0'); // VACACIONES
            $table->decimal('days_year',5,2)->nullable()->default('0'); // TOTAL A RESTAR
            $table->decimal('days_programming',5,2)->nullable()->default('0'); // DÍAS DEL AÑO

            $table->unsignedInteger('programming_id');
            

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
        Schema::dropIfExists('pro_programming_days');
    }
}
