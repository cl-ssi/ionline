<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\HotelBooking\Room;

class CreateHbRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotel_id')->nullable()->constrained('hb_hotels');
            $table->foreignId('room_type_id')->nullable()->constrained('hb_room_types');
            $table->string('identifier'); //cabaña 1, habitación 101, cama 01. 
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Room::create([
            'hotel_id' => 1,
            'room_type_id' => 2,
            'identifier' => 'Habitación 202',
            'description' => 'Corresponde a una habitación para dos personas'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_rooms');
    }
}
