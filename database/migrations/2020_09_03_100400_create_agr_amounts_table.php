<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount')->unsigned()->nullable();
            $table->enum('subtitle',['21','22','24', '29'])->nullable();
            $table->bigInteger('agreement_id')->unsigned();
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
}
