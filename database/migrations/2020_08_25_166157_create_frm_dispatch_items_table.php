<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmDispatchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_dispatch_items', function (Blueprint $table) {

          $table->bigIncrements('id');
          $table->bigInteger('barcode')->nullable();
          $table->unsignedBigInteger('dispatch_id');
          $table->unsignedBigInteger('product_id');
          $table->double('amount', 8, 2); //cantidad
          $table->string('unity');
          $table->dateTime('due_date')->nullable(); //fecha vencimiento
          //$table->dateTime('date'); //fecha xfecha
          //$table->longText('serial_number'); //serie
          $table->longText('batch'); //lote

          $table->timestamps();
          $table->softDeletes();

          $table->foreign('dispatch_id')->references('id')->on('frm_dispatches')->onDelete('cascade');
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
        Schema::dropIfExists('frm_dispatch_items');
    }
}
