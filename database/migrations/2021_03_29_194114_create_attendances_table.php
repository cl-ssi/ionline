<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->tinyInteger('type');
            $table->datetime('timestamp');
            $table->foreignId('clock_id');
            $table->timestamps();

            $table->unique(["user_id", "type", "timestamp"], 'user_type_timestamp_unique');

            /* No tiene claves foraneas porque guardamos todas las asistencias sin tener a los usuarios */
            /* No hay tabla reloj por ahora */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_attendances');
    }
}
