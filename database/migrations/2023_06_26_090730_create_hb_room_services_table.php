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
        Schema::create('hb_room_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('hb_rooms');
            $table->foreignId('service_id')->nullable()->constrained('hb_services');
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
        Schema::dropIfExists('hb_room_services');
    }
};
