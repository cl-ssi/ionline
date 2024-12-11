<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_purchases_items', function (Blueprint $table) {

            $table->id();
            $table->string('barcode')->nullable();
            $table->foreignId('purchase_id')->constrained('frm_purchases')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('frm_products');
            $table->double('amount', 12, 4); //cantidad
            $table->string('unity');
            $table->decimal('unit_cost', 12, 4);
            $table->dateTime('due_date')->nullable(); //fecha vencimiento
            //$table->dateTime('date'); //fecha xfecha
            //$table->longText('serial_number'); //serie
            $table->longText('batch')->nullable(); //lote
            $table->foreignId('reception_item_id')->nullable()->constrained('fin_reception_items')->onDelete('set null');
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
        Schema::dropIfExists('frm_purchases_items');
    }
};
