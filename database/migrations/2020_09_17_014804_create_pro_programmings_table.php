<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProgrammingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_programmings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->year('year');
            $table->string('description')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('establishment_id');
            $table->timestamps();

            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_programmings');
    }
}
