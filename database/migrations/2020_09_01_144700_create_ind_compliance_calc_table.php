<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndComplianceCalcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_compliance_calc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('left_result_value', 6, 3)->nullable(); //ponderación por corte
            $table->enum('left_result_operator',['<','<='])->nullable();
            $table->decimal('right_result_value', 6, 3)->nullable(); //ponderación por corte
            $table->enum('right_result_operator',['<','<=', '>', '>=', '='])->nullable();
            $table->string('result_text')->nullable();
            $table->decimal('compliance_value')->nullable();
            $table->string('compliance_text')->nullable();
            $table->timestamps();
            $table->bigInteger('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('ind_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ind_compliance_calc');
    }
}
