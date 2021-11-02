<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToRrhhShiftUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_shift_users', function (Blueprint $table) {
           $table->integer('position')->after('groupname')->nullable();
           $table->text('commentary')->after('groupname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_shift_users', function (Blueprint $table) {
            //
        });
    }
}
