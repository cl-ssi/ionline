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
        Schema::create('rst_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('organizational_unit_id');
            $table->string('job_title');
            $table->foreignId('technical_evaluation_id');
            $table->foreignId('register_user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('technical_evaluation_id')->references('id')->on('rst_technical_evaluations');
            $table->foreign('register_user_id')->references('id')->on('users');

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
        Schema::dropIfExists('rst_commissions');
    }
};
