<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqTenderPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_tender_purchases', function (Blueprint $table) {
            $table->id();
            $table->date('po_date')->nullable();
            $table->date('po_sent_date')->nullable();
            $table->date('po_accepted_date')->nullable();
            $table->date('po_with_confirmed_receipt_date')->nullable();
            $table->float('po_amount', 15, 2)->nullable();
            $table->date('estimated_delivery_date')->nullable();

            $table->foreignId('supplier_id')->nullable()->constrained('cfg_suppliers');
            $table->foreignId('tender_id')->nullable()->constrained('arq_tenders');

            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_tender_purchases');
    }
}
