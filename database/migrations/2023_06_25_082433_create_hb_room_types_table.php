<?php

use App\Models\HotelBooking\RoomType;
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
        Schema::create('hb_room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //cabaña, habitación, cama en habitación compartida, etc.
            $table->timestamps();
            $table->softDeletes();
        });

        RoomType::create([
            'name' => 'Cabaña',
        ]);
        RoomType::create([
            'name' => 'Habitación',
        ]);
        RoomType::create([
            'name' => 'Cama en habitación compartida',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_room_types');
    }
};
