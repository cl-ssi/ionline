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
        Schema::create('pro_professional_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->unsignedBigInteger('programming_id');
            $table->integer('value')->nullable();
            $table->timestamps();

            //$table->foreign('professional_id')->references('id')->on('pro_professionals');
            //$table->foreign('programming_id')->references('id')->on('pro_programmings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_professional_hours');
    }
};
