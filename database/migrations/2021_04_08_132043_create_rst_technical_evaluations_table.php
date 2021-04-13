<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstTechnicalEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_technical_evaluations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_end')->nullable();
            $table->enum('technical_evaluation_status',['pending', 'complete', 'rejected']);
            $table->foreignId('user_id');
            $table->foreignId('organizational_unit_id');
            $table->foreignId('request_replacement_staff_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('request_replacement_staff_id')->references('id')->on('rst_request_replacement_staff');

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
        Schema::dropIfExists('rst_technical_evaluations');
    }
}
