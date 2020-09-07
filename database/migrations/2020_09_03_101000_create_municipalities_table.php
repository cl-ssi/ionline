<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_municipality');
            $table->string('rut_municipality');
            $table->string('adress_municipality');

            $table->string('appellative_representative'); // APELATIVO DON ALCALDE, DON ALCALDE SUBROGANTE
            $table->string('decree_representative'); // DECRETO ALCALDICIO
            $table->string('name_representative');
            $table->string('rut_representative');
            $table->unsignedInteger('commune_id');
            $table->timestamps();

            $table->foreign('commune_id')->references('id')->on('communes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipalities');
    }
}
