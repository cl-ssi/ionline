<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhUserRequestOfDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_user_request_of_days', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('commentary')->nullable();
            $table->unsignedBigInteger('shift_user_day_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_change_by');


            $table->foreign('status_change_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shift_user_day_id')->references('id')->on('rrhh_shift_user_days');
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
        Schema::dropIfExists('rrhh_user_request_of_days');
    }
}
