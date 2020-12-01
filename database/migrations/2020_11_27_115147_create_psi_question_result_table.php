<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsiQuestionResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psi_question_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id');
            $table->foreign('result_id')->references('id')->on('psi_results')->onDelete('cascade');
            $table->foreignId('option_id');
            $table->foreign('option_id')->references('id')->on('psi_results')->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psi_question_result');
    }
}
