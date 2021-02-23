<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vac_slots', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->unsignedInteger('available')->default(0);
            $table->unsignedInteger('used')->default(0);
            $table->foreignId('day_id');
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('vac_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vac_slots');
    }
}
