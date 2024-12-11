<?php

use App\Models\HotelBooking\Hotel;
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
        Schema::create('hb_hotels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('region_id')->nullable()->constrained('cl_regions');
            $table->foreignId('commune_id')->nullable()->constrained('cl_regions');
            $table->string('name');
            $table->string('address');
            $table->string('description');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('manager_phone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Hotel::create([
        //     'region_id' => 1,
        //     'commune_id' => 5,
        //     'name' => 'Hotel Ibis',
        //     'address' => 'Orella 462',
        //     'description' => 'El hotel ibis es un hotal 3 estrellas, que proporciona un servicio inmejorable en la ciudad de Iquique. Todos los funcionarios del servicio de salud de Iquique están invitados a nuestras instalaciones.',
        //     'latitude' => '1.1',
        //     'longitude' => '2.2'
        // ]);

        // Hotel::create([
        //     'region_id' => 1,
        //     'commune_id' => 5,
        //     'name' => 'Hotel Tantakui',
        //     'address' => 'La huaica',
        //     'description' => 'El hotel tantakui es un hotel holistico que ofrece distinto tipo de servicios para un excelente fin de semana para toda la familia. Todos los funcionarios del servicio de salud de Iquique están invitados a nuestras instalaciones.',
        //     'latitude' => '12.22',
        //     'longitude' => '54.112'
        // ]);
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
};
