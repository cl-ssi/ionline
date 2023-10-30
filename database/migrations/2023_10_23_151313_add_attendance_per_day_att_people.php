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
        Schema::table('att_people', function (Blueprint $table) {
            $table->boolean('asistencia_dia_2')->nullable();
            $table->boolean('asistencia_tarde_2')->nullable();
            $table->boolean('asistencia_dia_1')->nullable();
            $table->dropColumn('asistencia');
            $table->dropColumn('esFuncionario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('att_people', function (Blueprint $table) {
            $table->dropColumn('asistencia_dia_1');
            $table->dropColumn('asistencia_dia_2');
            $table->dropColumn('asistencia_tarde_2');
            $table->string('esFuncionario');
            $table->boolean('asistencia');
        });
    }
};
