<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('barcode')->nullable();
            $table->string('name');
            $table->string('unit');
            $table->date('expiration')->nullable();
            //$table->string('batch')->nullable();
            $table->integer('price')->nullable();
            $table->integer('stock');
            $table->integer('critic_stock')->nullable();
            $table->longText('storage_conditions')->nullable(); 
            //$table->string('category');
            //$table->string('program')->nullable();
            //$table->integer('valued'); On the fly

            $table->unsignedBigInteger('pharmacy_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('program_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pharmacy_id')->references('id')->on('frm_pharmacies');
            $table->foreign('category_id')->references('id')->on('frm_categories');
            $table->foreign('program_id')->references('id')->on('frm_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_products');
    }
}
