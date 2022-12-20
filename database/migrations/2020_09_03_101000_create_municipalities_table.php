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
            $table->id();
            $table->string('name_municipality');
            $table->string('rut_municipality');
            $table->string('adress_municipality');

            $table->string('appellative_representative'); // APELATIVO DON ALCALDE, DON ALCALDE SUBROGANTE
            $table->string('decree_representative'); // DECRETO ALCALDICIO
            $table->string('name_representative');
            $table->string('rut_representative');
            $table->foreignId('commune_id')->constrained('communes');
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
        Schema::dropIfExists('municipalities');
    }
}
