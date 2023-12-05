<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->unique(['rut','correlativo'],'UNIQUE');
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
            //
        });
    }
};
