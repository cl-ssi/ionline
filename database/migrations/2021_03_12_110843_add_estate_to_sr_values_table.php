<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstateToSrValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sr_values', function (Blueprint $table) {
            $table->enum('estate', ['Profesional Médico', 'Profesional', 'Técnico', 'Administrativo', 'Farmaceutico', 'Odontólogo', 'Bioquímico', 'Auxiliar', 'Otro (justificar)'])
                ->after('work_type')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sr_values', function (Blueprint $table) {
            $table->dropColumn('estate');
        });
    }
}
