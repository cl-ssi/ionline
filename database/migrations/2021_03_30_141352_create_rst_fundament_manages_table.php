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
        Schema::create('rst_fundament_manages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rst_fundament_legal_quality', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundament_manage_id')->unsigned();
            $table->foreign('fundament_manage_id')->references('id')->on('rst_fundament_manages')->onDelete('cascade');

            $table->foreignId('legal_quality_manage_id')->unsigned();
            $table->foreign('legal_quality_manage_id')->references('id')->on('rst_legal_quality_manages')->onDelete('cascade');

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
        Schema::dropIfExists('rst_fundament_legal_quality');
        Schema::dropIfExists('rst_fundament_manages');
    }
};
