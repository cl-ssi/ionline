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
        Schema::create('agr_amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->unsigned()->nullable();
            $table->enum('subtitle', ['21', '22', '24', '29'])->nullable();
            $table->bigInteger('agreement_id')->unsigned()->nullable();
            $table->foreignId('program_resolution_id')->nullable()->constrained('agr_program_resolutions');
            $table->bigInteger('program_component_id')->unsigned();
            $table->timestamps();
            //$table->softDeletes();

            $table->foreign('agreement_id')->references('id')->on('agr_agreements');
            $table->foreign('program_component_id')->references('id')->on('agr_program_components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_amounts');
    }
};
