<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhShiftUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_shift_users', function (Blueprint $table) {
            $table->id();
            $table->date('date_from');
            $table->date('date_up');
            $table->unsignedBigInteger('asigned_by');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shift_types_id');
            $table->unsignedBigInteger('organizational_units_id');
            

            $table->foreign('shift_types_id')->references('id')->on('rrhh_shift_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('asigned_by')->references('id')->on('users');
            $table->foreign('organizational_units_id')->references('id')->on('organizational_units');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_shift_users');
    }
}
