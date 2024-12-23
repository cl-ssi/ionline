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
        Schema::create('agr_program_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('program_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_id')->references('id')->on('agr_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_program_components');
    }
};
