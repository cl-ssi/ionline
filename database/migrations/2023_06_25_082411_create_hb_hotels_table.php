<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\HotelBooking\Hotel;

class CreateHbHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_hotels', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('region_id')->nullable()->constrained('cl_regions');
            $table->foreignId('commune_id')->nullable()->constrained('cl_regions');
            $table->string('name');
            $table->string('address');
            $table->string('description');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Hotel::create([
            'region_id' => 1,
            'commune_id' => 5,
            'name' => 'Hotel Ibis',
            'address' => 'Orella 462',
            'description' => 'El hotel ibis es un hotal 3 estrellas, que proporciona un servicio inmejorable en la ciudad de Iquique. Todos los funcionarios del servicio de salud de Iquique están invitados a nuestras instalaciones.',
            'latitude' => '1.1',
            'longitude' => '2.2'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_hotels');
    }
}
