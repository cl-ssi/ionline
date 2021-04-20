<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_applicants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->integer('score')->nullable();
            $table->longText('observations')->nullable();
            //Exclusive Selected
            $table->boolean('selected')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('name_to_replace')->nullable();
            $table->string('replacement_reason')->nullable();
            $table->string('place_of_performance')->nullable();
            $table->foreignId('technical_evaluation_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('technical_evaluation_id')->references('id')->on('rst_technical_evaluations');

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
        Schema::dropIfExists('rst_applicants');
    }
}
