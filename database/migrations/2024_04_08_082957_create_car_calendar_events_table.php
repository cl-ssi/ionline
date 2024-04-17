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
        Schema::create('car_calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Sin Titulo');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('state')->nullable();
            $table->string('backgroundColor')->nullable();
            $table->string('display')->default('block');
            $table->string('location');
            $table->string('car_licence_number')->nullable();
            $table->string('passenger_number')->default(1)->nullable();
            $table->string('type');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('requester_id');
            $table->foreign('requester_id')->references('id')->on('users');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('users');
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
        Schema::dropIfExists('car_calendar_events');
    }
};
