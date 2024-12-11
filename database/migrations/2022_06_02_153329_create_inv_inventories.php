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
        Schema::create('inv_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('number', 255);
            $table->string('old_number', 255)->nullable();
            $table->integer('useful_life')->nullable();
            $table->string('brand', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('serial_number', 255)->nullable();

            $table->string('po_code', 255)->nullable();
            $table->string('po_price', 255)->nullable();
            $table->string('po_date', 255)->nullable();
            $table->integer('dte_number')->nullable();
            $table->integer('status')->nullable();
            // Falta table Observations
            $table->timestamp('discharge_date')->nullable();
            $table->string('act_number', 255)->nullable();
            $table->string('depreciation', 255)->nullable();

            // delivered at
            $table->timestamp('deliver_date')->nullable();
            $table->string('description', 255)->nullable();
            $table->text('internal_description')->nullable();
            $table->text('removal_request_reason')->nullable();
            $table->datetime('removal_request_reason_at')->nullable();
            $table->boolean('is_removed')->nullable()->default(null);
            $table->foreignId('removed_user_id')->nullable()->constrained('users');
            $table->datetime('removed_at')->nullable();
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');

            // requested by
            $table->foreignId('request_user_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('request_user_id')->nullable()->constrained('users');
            $table->foreignId('user_responsible_id')->nullable()->constrained('users');
            $table->foreignId('user_using_id')->nullable()->constrained('users');
            $table->foreignId('product_id')->nullable()->constrained('wre_products');
            $table->foreignId('unspsc_product_id')->nullable()->constrained('unspsc_products');
            $table->foreignId('control_id')->nullable()->constrained('wre_controls');
            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('place_id')->nullable()->constrained('cfg_places');
            $table->foreignId('po_id')->nullable()->constrained('arq_purchase_orders');
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->foreignId('budget_item_id')->nullable()->constrained('cfg_budget_items');
            $table->foreignId('accounting_code_id')->nullable()->constrained('fin_accounting_codes');
            $table->foreignId('classification_id')->nullable()->constrained('inv_classifications');
            $table->boolean('printed')->nullable()->default(false);
            $table->string('observation_delete')->nullable(true);
            $table->foreignId('user_delete_id')->nullable(true)->constrained('users');

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
        Schema::dropIfExists('inv_inventories');
    }
};
