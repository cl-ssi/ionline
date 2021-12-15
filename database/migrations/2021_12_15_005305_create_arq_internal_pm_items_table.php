<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqInternalPmItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_internal_pm_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('internal_purchase_order_id')->constrained('arq_internal_purchase_orders');
            $table->foreignId('item_id')->constrained('arq_item_request_forms');

            /* Updated items in purchasing process */
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedInteger('unit_value')->nullable();
            $table->unsignedInteger('expense')->nullable();
            $table->enum('status', ['in_progress', 'total', 'partial', 'desert',  'timed_out', 'not_available'])->nullable();

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
        Schema::dropIfExists('arq_internal_pm_items');
    }
}
