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
        Schema::create('arq_internal_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date', $precision = 0);
            $table->foreignId('supplier_id')->constrained('cfg_suppliers');
            $table->string('payment_condition');
            $table->date('estimated_delivery_date')->nullable();

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
};
