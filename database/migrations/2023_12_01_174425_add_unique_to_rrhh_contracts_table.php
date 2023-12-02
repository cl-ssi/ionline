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
        DB::update("TRUNCATE TABLE rrhh_contracts");

        Schema::table('rrhh_contracts', function (Blueprint $table) {
            $table->unique(['rut']);
            $table->unique(['correlativo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_contracts', function (Blueprint $table) {
            $table->dropUnique('rrhh_contracts_rut_unique');
            $table->dropUnique('rrhh_contracts_correlativo_unique');
        });
    }
};
