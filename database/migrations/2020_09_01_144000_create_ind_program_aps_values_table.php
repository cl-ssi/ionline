<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndProgramApsValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_program_aps_values', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo');
            $table->foreignId('program_aps_glosa_id')->constrained('ind_program_aps_glosas');
            $table->integer('poblacion')->unsigned()->nullable();
            $table->integer('cobertura')->unsigned()->nullable();
            $table->integer('concentracion')->unsigned()->nullable();
            $table->integer('actividadesProgramadas')->nullable();
            $table->integer('observadoAnterior')->nullable();
            $table->string('rendimientoProfesional')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('commune_id')->constrained('communes');
            $table->foreignId('establishment_id')->constrained('establishments');
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
        Schema::dropIfExists('ind_program_aps_values');
    }
}
