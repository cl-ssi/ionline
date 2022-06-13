<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInventories extends Migration
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

            $table->integer('number')->nullable();
            $table->integer('useful_life')->nullable();

            $table->string('brand', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('serial_number', 255)->nullable();

            $table->string('po_code', 255)->nullable();
            $table->string('po_price', 255)->nullable();
            $table->string('po_date', 255)->nullable();

            // delivered at
            $table->boolean('reception_confirmation')->nullable();
            $table->timestamp('deliver_date')->nullable();
            $table->foreignId('delivered_user_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('delivered_user_id')->nullable()->constrained('users');

            // requested by
            $table->foreignId('request_user_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('request_user_id')->nullable()->constrained('users');

            $table->foreignId('product_id')->nullable()->constrained('wre_products');
            $table->foreignId('control_id')->nullable()->constrained('wre_controls');
            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('place_id')->nullable()->constrained('cfg_places');
            $table->foreignId('po_id')->nullable()->constrained('arq_purchase_orders');
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');

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
}
