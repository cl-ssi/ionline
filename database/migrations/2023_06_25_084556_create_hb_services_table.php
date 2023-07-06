<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\HotelBooking\Service;

class CreateHbServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img_url');
            $table->timestamps();
            $table->softDeletes();
        });

        Service::create([
            'name' => 'Conserjería'
        ]);

        Service::create([
            'name' => 'Agua caliente'
        ]);

        Service::create([
            'name' => 'Servicio a la habitación'
        ]);

        Service::create([
            'name' => 'Desayuno'
        ]);

        Service::create([
            'name' => 'Servicio de lavandería'
        ]);

        Service::create([
            'name' => 'Piscina'
        ]);

        Service::create([
            'name' => 'Toallas'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_services');
    }
}
