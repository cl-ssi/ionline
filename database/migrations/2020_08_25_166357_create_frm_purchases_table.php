<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_purchases', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->unsignedBigInteger('supplier_id');
            $table->longText('purchase_order'); //orden de compra
            $table->longText('notes')->nullable();
            $table->bigInteger('invoice')->nullable(); //factura
            $table->bigInteger('despatch_guide')->nullable(); //guìa de despacho
            $table->dateTime('invoice_date')->nullable(); //fecha de factura
            $table->unsignedBigInteger('pharmacy_id');
            $table->longText('destination')->nullable(); //destino
            $table->longText('from')->nullable(); //fondo
            //$table->longText('acceptance_certificate'); //acta de recepción
            $table->dateTime('purchase_order_date'); //fecha orden de compra
            $table->dateTime('doc_date')->nullable(); //fecha documento
            $table->decimal('purchase_order_amount', 12, 4)->nullable(); //monto orden de compra
            //$table->longText('content'); //contenido
            $table->decimal('invoice_amount', 12, 4)->nullable(); //monto factura
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('frm_suppliers');
            $table->foreign('pharmacy_id')->references('id')->on('frm_pharmacies');
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
        Schema::dropIfExists('frm_purchases');
    }
}
