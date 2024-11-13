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

          $table->id();
          $table->string('barcode')->nullable();
          $table->foreignId('dispatch_id')->constrained('frm_dispatches')->onDelete('frm_dispatches')
          $table->foreignId('product_id')->constrained('frm_products');
          $table->double('amount', 8, 2); //cantidad
          $table->string('unity');
          $table->dateTime('due_date')->nullable(); //fecha vencimiento
          //$table->dateTime('date'); //fecha xfecha
          //$table->longText('serial_number'); //serie
          $table->longText('batch'); //lote
          $table->foreignId('batch_id')->nullable()->constrained('frm_batchs');

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
        Schema::dropIfExists('frm_dispatch_items');
    }
}
