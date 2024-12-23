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
        Schema::create('rst_assign_evaluations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_replacement_staff_id');
            $table->foreignId('from_user_id');
            $table->foreignId('to_user_id');
            $table->text('observation')->nullable();
            $table->string('status')->nullable();

            $table->foreign('request_replacement_staff_id')->references('id')->on('rst_request_replacement_staff');
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');

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
        Schema::dropIfExists('rst_assign_evaluations');
    }
};
