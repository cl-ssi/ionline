<?php

use App\Models\HotelBooking\Service;
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
        Schema::create('hb_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insertar múltiples registros en una sola consulta
        Service::insert([
            ['name' => 'Conserjería'],
            ['name' => 'Agua caliente'],
            ['name' => 'Servicio a la habitación'],
            ['name' => 'Desayuno'],
            ['name' => 'Servicio de lavandería'],
            ['name' => 'Piscina'],
            ['name' => 'Toallas'],
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
};
