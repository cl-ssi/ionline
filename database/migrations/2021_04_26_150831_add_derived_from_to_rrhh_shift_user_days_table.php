<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDerivedFromToRrhhShiftUserDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_shift_user_days', function (Blueprint $table) {
             $table->integer('derived_from')->nullable()->after('working_day');
                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('to_rrhh_shift_user_days', function (Blueprint $table) {
            //
        });
    }
}
