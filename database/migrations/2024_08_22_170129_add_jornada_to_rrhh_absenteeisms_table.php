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
        Schema::table('rrhh_absenteeisms', function (Blueprint $table) {
            $table->string('jornada',2)->after('tipo_de_contrato')->nullable();
            $table->string('observacion')->after('jornada')->nullable();
            $table->dateTime('sirh_at')->after('observacion')->nullable();
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
            $table->dropColumn('jornada');
            $table->dropColumn('observacion');
            $table->dropColumn('sirh_at');
        });
    }
};
