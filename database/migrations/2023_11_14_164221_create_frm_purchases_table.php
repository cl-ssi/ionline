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
        Schema::create('frm_purchases', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('supplier_id')->constrained('frm_suppliers');
            $table->longText('purchase_order'); //orden de compra
            $table->string('order_number')->nullable();
            $table->longText('notes')->nullable();
            $table->bigInteger('invoice')->nullable(); //factura
            $table->bigInteger('despatch_guide')->nullable(); //guìa de despacho
            $table->dateTime('invoice_date')->nullable(); //fecha de factura
            $table->text('commission')->nullable();
            $table->foreignId('pharmacy_id')->constrained('frm_pharmacies');
            $table->longText('destination')->nullable(); //destino
            $table->longText('from')->nullable(); //fondo
            //$table->longText('acceptance_certificate'); //acta de recepción
            $table->dateTime('purchase_order_date'); //fecha orden de compra
            $table->dateTime('doc_date')->nullable(); //fecha documento
            $table->decimal('purchase_order_amount', 12, 4)->nullable(); //monto orden de compra
            //$table->longText('content'); //contenido
            $table->decimal('invoice_amount', 12, 4)->nullable(); //monto factura
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('reception_id')->nullable()->constrained('fin_receptions')->onDelete('set null');
            $table->foreignId('signed_record_id')->nullable()->constrained('doc_signatures_files');

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
        Schema::dropIfExists('frm_purchases');
    }
};
