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
        Schema::create('frm_receiving_items', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->foreignId('receiving_id')->constrained('frm_receivings')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('frm_products');
            //FIX: @sickiqq double con 8,2 ya no existe en laravel 11 ver documentación de update a laravel 11 seccion floating-points-types
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
        Schema::dropIfExists('frm_receiving_items');
    }
};
