<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsiRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psi_requests', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('job');
            $table->date('start_date');
            $table->string('status');
            $table->boolean('disability');
            $table->foreignId('user_external_id');
            $table->foreign('user_external_id')->references('id')->on('users_external');
            $table->foreignId('user_creator_id');
            $table->foreign('user_creator_id')->references('id')->on('users_external');
            $table->foreignId('school_id');
            $table->foreign('school_id')->references('id')->on('schools');
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
        Schema::dropIfExists('psi_requests');
    }
}
