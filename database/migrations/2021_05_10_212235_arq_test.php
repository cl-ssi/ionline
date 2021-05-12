<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArqTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_test', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->foreignId('user_id');             
             $table->string('name');
             $table->string('airline');
             $table->timestamps();
             $table->softDeletes();

             $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('flights');
    }
}
