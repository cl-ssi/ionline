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
        Schema::create('prof_agenda_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('open_hour_id')->constrained('prof_agenda_open_hours')->onDelete('cascade');
            $table->datetime('begin_date'); //comienzo citas
            $table->datetime('discharged_date')->nullable(); //dado de alta
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
        Schema::dropIfExists('prof_agenda_appointments');
    }
};
