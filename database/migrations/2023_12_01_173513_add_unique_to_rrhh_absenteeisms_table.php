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
        DB::update("TRUNCATE TABLE rrhh_absenteeisms");

        Schema::table('rrhh_absenteeisms', function (Blueprint $table) {
            $table->unique(['rut']);
            $table->unique('finicio');
            $table->unique('ftermino');
            $table->unique('absenteeism_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_absenteeisms', function (Blueprint $table) {
            $table->dropUnique('rrhh_absenteeisms_rut_unique');
            $table->dropUnique('rrhh_absenteeisms_finicio_unique');
            $table->dropUnique('rrhh_absenteeisms_ftermino_unique');
            $table->dropUnique('rrhh_absenteeisms_absenteeism_type_id_unique');
        });
    }
};
