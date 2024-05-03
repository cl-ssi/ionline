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
        Schema::table('rrhh_authorities', function (Blueprint $table) {
            $table->unique(['date','organizational_unit_id','type']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_authorities', function (Blueprint $table) {
            $table->dropUnique(['date','organizational_unit_id','type']);
        });
    }
};
