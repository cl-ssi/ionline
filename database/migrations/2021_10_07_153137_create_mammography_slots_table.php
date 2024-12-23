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
        Schema::create('mammography_slots', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->unsignedInteger('available')->default(0);
            $table->unsignedInteger('used')->default(0);
            $table->foreignId('mammography_day_id');

            $table->foreign('mammography_day_id')->references('id')->on('mammography_days');

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
        Schema::dropIfExists('mammography_slots');
    }
};
