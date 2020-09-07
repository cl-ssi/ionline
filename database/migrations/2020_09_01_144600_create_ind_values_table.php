<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('month');
            $table->enum('factor',['numerador','denominador']);
            $table->integer('value')->default(0);
            $table->timestamps();
            $table->bigInteger('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('ind_actions');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ind_values');
    }
}
