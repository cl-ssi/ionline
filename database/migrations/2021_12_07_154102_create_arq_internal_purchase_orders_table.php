<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqInternalPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_internal_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date', $precision = 0);
            $table->foreignId('supplier_id')->constrained('cfg_suppliers');
            $table->string('payment_condition');
            $table->foreignId('purchasing_process_id')->constrained('arq_purchasing_processes');

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
        Schema::dropIfExists('arq_internal_purchase_orders');
    }
}
