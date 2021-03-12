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
            $table->enum('estate', ['Médico 44', 'Médico 28', 'Médico 22', 'Profesional', 'Técnico', 'Administrativo', 'Farmaceutico', 'Odontólogo', 'Bioquímico', 'Auxiliar', 'Otro (justificar)'])
                ->after('work_type')
                ->nullable();
            $table->float('amount', 8,2)->change();
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
            $table->integer('amount')->change();
        });
    }
}
