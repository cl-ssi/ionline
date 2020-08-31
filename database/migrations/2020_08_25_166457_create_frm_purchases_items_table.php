<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmPurchasesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_purchases_items', function (Blueprint $table) {

          $table->bigIncrements('id');
          $table->bigInteger('barcode')->nullable();
          $table->unsignedBigInteger('purchase_id');
          $table->unsignedBigInteger('product_id');
          $table->double('amount', 12, 4); //cantidad
          $table->string('unity');
          $table->decimal('unit_cost', 12, 4);
          $table->dateTime('due_date')->nullable(); //fecha vencimiento
          //$table->dateTime('date'); //fecha xfecha
          //$table->longText('serial_number'); //serie
          $table->longText('batch')->nullable(); //lote

          $table->timestamps();
          $table->softDeletes();

          $table->foreign('purchase_id')->references('id')->on('frm_purchases')->onDelete('cascade');
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
        Schema::dropIfExists('frm_purchases_items');
    }
}
