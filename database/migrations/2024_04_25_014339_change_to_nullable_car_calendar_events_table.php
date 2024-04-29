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
        Schema::table('car_calendar_events', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->unsignedBigInteger('requester_id')->nullable()->change();
            $table->unsignedBigInteger('driver_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_calendar_events', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
            $table->unsignedBigInteger('requester_id')->nullable(false)->change();
            $table->unsignedBigInteger('driver_id')->nullable(false)->change();
        });
    }
};
