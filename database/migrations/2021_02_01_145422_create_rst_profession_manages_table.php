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
        Schema::create('rst_profession_manages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('profile_manage_id');

            $table->foreign('profile_manage_id')->references('id')->on('rst_profile_manages');
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
        Schema::dropIfExists('rst_profession_manages');
    }
};
