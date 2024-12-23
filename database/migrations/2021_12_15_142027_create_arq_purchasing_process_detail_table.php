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
        Schema::create('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchasing_process_id')->constrained('arq_purchasing_processes');
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->foreignId('item_request_form_id')->nullable()->constrained('arq_item_request_forms');
            $table->foreignId('passenger_request_form_id')->nullable()->constrained('arq_passengers');
            $table->foreignId('internal_purchase_order_id')->nullable()->constrained('arq_internal_purchase_orders');
            $table->foreignId('petty_cash_id')->nullable()->constrained('arq_petty_cash');
            $table->foreignId('fund_to_be_settled_id')->nullable()->constrained('arq_funds_to_be_settled');
            $table->foreignId('tender_id')->nullable()->constrained('arq_tenders');
            $table->foreignId('direct_deal_id')->nullable()->constrained('arq_direct_deals');
            $table->foreignId('immediate_purchase_id')->nullable()->constrained('arq_immediate_purchases');
            $table->foreignId('user_id')->constrained('users'); //Usuario que registró el detalle.
            $table->string('supplier_run')->nullable();
            $table->text('supplier_name')->nullable();
            $table->text('supplier_specifications')->nullable();

            /* Updated items in purchasing process */
            $table->float('quantity')->nullable();
            $table->float('unit_value', 15, 2)->nullable();
            $table->string('tax')->nullable();
            $table->float('charges', 15, 2)->nullable();
            $table->float('discounts', 15, 2)->nullable();
            $table->float('expense', 15, 2)->nullable();
            $table->enum('status', ['pending', 'total', 'partial', 'desert', 'timed_out', 'not_available'])->nullable();
            $table->text('release_observation')->nullable();

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
        Schema::dropIfExists('arq_purchasing_process_detail');
    }
};
