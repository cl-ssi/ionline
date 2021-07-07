<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftCloseIdToRrhhShiftUserDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_shift_user_days', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_close_id')->after('shift_user_id')->nullable();
            $table->foreign('shift_close_id')->references('id')->on('rrhh_shift_close');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_shift_user_days', function (Blueprint $table) {
            //
        });
    }
}
