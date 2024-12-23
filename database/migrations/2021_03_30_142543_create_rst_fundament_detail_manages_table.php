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
        Schema::create('rst_fundament_detail_manages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rst_detail_fundaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundament_detail_id')->unsigned();
            $table->foreign('fundament_detail_id')->references('id')->on('rst_fundament_detail_manages')->onDelete('cascade');

            $table->foreignId('fundament_manage_id')->unsigned();
            $table->foreign('fundament_manage_id')->references('id')->on('rst_fundament_manages')->onDelete('cascade');

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
        Schema::dropIfExists('rst_detail_fundaments');
        Schema::dropIfExists('rst_fundament_detail_manages');
    }
};
