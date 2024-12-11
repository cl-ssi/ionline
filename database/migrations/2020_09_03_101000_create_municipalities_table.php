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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('name_municipality');
            $table->string('rut_municipality');
            $table->string('email_municipality')->nullable();
            $table->string('email_municipality_2')->nullable();
            $table->string('adress_municipality');
            $table->string('appellative_representative'); // APELATIVO DON ALCALDE, DON ALCALDE SUBROGANTE
            $table->string('decree_representative'); // DECRETO ALCALDICIO
            $table->string('name_representative');
            $table->string('rut_representative');
            $table->foreignId('commune_id')->constrained('communes');
            $table->string('name_representative_surrogate')->nullable();
            $table->string('rut_representative_surrogate')->nullable();
            $table->string('decree_representative_surrogate')->nullable();
            $table->string('appellative_representative_surrogate')->nullable();

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
};
