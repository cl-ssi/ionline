<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhUserShifttypeMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_user_shifttype_months', function (Blueprint $table) {
            $table->id();
            $table->integer("month")->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shift_type_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shift_type_id')->references('id')->on('rrhh_shift_types');
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
        Schema::dropIfExists('rrhh_user_shifttype_months');
    }
}
