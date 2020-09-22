<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProfessionalHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_professional_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('professional_id');
            $table->unsignedInteger('programming_id');
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
}
