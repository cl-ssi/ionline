<?php

use App\Models\HotelBooking\Room;
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
        Schema::create('hb_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotel_id')->nullable()->constrained('hb_hotels');
            $table->foreignId('room_type_id')->nullable()->constrained('hb_room_types');
            $table->string('identifier'); //cabaña 1, habitación 101, cama 01.
            $table->string('description');
            $table->integer('max_days_avaliable');
            $table->integer('single_bed')->nullable();
            $table->integer('double_bed')->nullable();
            $table->string('status')->default(1);
            $table->integer('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Room::create([
        //     'hotel_id' => 1,
        //     'room_type_id' => 2,
        //     'identifier' => 'Habitación 202',
        //     'description' => 'Corresponde a una habitación para dos personas.',
        //     'max_days_avaliable' => 3,
        //     'double_bed' => 1
        // ]);

        // Room::create([
        //     'hotel_id' => 1,
        //     'room_type_id' => 2,
        //     'identifier' => 'Habitación 502',
        //     'description' => 'Corresponde a una habitación para cuatro personas.',
        //     'max_days_avaliable' => 2,
        //     'single_bed' => 2,
        //     'double_bed' => 1
        // ]);

        // Room::create([
        //     'hotel_id' => 2,
        //     'room_type_id' => 1,
        //     'identifier' => 'Cabaña 01',
        //     'description' => 'Corresponde a cabaña con capacidad para 5 personas. Tiene quincho y vista a la piscina del complejo.',
        //     'max_days_avaliable' => 3,
        //     'single_bed' => 1,
        //     'double_bed' => 2
        // ]);
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
};
