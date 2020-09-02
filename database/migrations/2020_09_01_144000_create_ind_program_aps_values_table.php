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
            $table->increments('id');
            $table->integer('periodo');
            $table->unsignedInteger('program_aps_glosa_id');
            $table->integer('poblacion')->unsigned()->nullable();
            $table->integer('cobertura')->unsigned()->nullable();
            $table->integer('concentracion')->unsigned()->nullable();
            $table->integer('actividadesProgramadas')->nullable();
            $table->integer('observadoAnterior')->nullable();
            $table->string('rendimientoProfesional')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedInteger('commune_id');
            $table->unsignedInteger('establishment_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_aps_glosa_id')->references('id')->on('ind_program_aps_glosas');
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->foreign('establishment_id')->references('id')->on('establishments');
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
