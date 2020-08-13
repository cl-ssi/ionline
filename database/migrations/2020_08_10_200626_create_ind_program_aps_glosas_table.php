<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndProgramApsGlosasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_program_aps_glosas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->integer('numero');
            $table->string('nivel');
            $table->string('prestacion');
            $table->string('poblacion');
            $table->string('verificacion');
            $table->string('profesional');
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
        Schema::dropIfExists('ind_program_aps_glosas');
    }
}
