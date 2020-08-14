<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrgProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drg_protocols', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('sample');
            $table->enum('result',['Positivo','Negativo']);
            $table->bigInteger('user_id')->unsigned();
            $table->unsignedInteger('reception_item_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reception_item_id')->references('id')->on('drg_reception_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drg_protocols');
    }
}
