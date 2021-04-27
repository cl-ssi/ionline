<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstTechnicalEvaluationFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_technical_evaluation_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');
            $table->foreignId('technical_evaluation_id');
            $table->foreignId('user_id');

            $table->foreign('technical_evaluation_id')->references('id')->on('rst_technical_evaluations');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('rst_technical_evaluation_files');
    }
}
