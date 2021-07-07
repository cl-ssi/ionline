<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhShiftCloseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_shift_close', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->integer('total_hours');

            $table->string('first_confirmation_commentary')->nullable();
            $table->string('first_confirmation_status')->nullable();
            $table->dateTime('first_confirmation_date')->nullable();

            $table->string('close_commentary')->nullable();
            $table->string('first_confirmation_status')->nullable();
            $table->dateTime('first_confirmation_date')->nullable();
            
            $table->unsignedBigInteger('first_confirmation_user_id')->nullable();
            $table->unsignedBigInteger('close_user_id')->nullable();
            $table->unsignedBigInteger('owner_of_the_days_id')->nullable();
            // $table->unsignedBigInteger('shift_user_id');
            
            $table->foreign('first_confirmation_user_id')->references('id')->on('users');
            $table->foreign('close_user_id')->references('id')->on('users');
            $table->foreign('owner_of_the_days_id')->references('id')->on('users');
            // $table->foreign('shift_user_day_id')->references('id')->on('rrhh_shift_user_days');

            $table->timestamps();
            $table->softDeletes();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_shift_close');
    }
}
