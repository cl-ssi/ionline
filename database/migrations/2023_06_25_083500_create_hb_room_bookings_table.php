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
        Schema::create('hb_room_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('room_id')->constrained('hb_rooms');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');  //Reservado - Cancelado - Día bloqueado
            $table->text('cancelation_observation')->nullable();
            $table->string('payment_type'); //Transferencia - Descuento por planilla
            $table->string('observation')->nullable();
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
        Schema::dropIfExists('hb_room_bookings');
    }
};
