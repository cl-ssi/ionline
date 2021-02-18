<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('training_name');
            $table->string('hours_training')->nullable();
            $table->string('file');

            $table->foreignId('replacement_staff_id');

            $table->foreign('replacement_staff_id')->references('id')->on('rst_replacement_staff');

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
        Schema::dropIfExists('rst_trainings');
    }
}
