<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmEstablishmentsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_establishments_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stock');
            $table->integer('critic_stock')->nullable();
            $table->integer('max_stock')->nullable();
            $table->unsignedBigInteger('establishment_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
        });

        Schema::table('frm_establishments_products', function ($table){
            $table->foreign('establishment_id')->references('id')->on('frm_establishments');
            $table->foreign('product_id')->references('id')->on('frm_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_establishments_products');
    }
}
