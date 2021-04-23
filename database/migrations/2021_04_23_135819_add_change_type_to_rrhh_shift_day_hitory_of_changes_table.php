<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeTypeToRrhhShiftDayHitoryOfChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_shift_day_hitory_of_changes', function (Blueprint $table) {
            $table->integer('change_type')->after('modified_by');
                    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_shift_day_hitory_of_changes', function (Blueprint $table) {
        });
    }
}
