<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('frm_transfers', function ($table){
            $table->foreign('from')->references('id')->on('frm_establishments');
            $table->foreign('to')->references('id')->on('frm_establishments');
            $table->foreign('product_id')->references('id')->on('frm_products');
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
        Schema::dropIfExists('frm_transfers');
    }
}
