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
            $table->string('applicant', 255)->nullable();// request form
            $table->foreignId('organization_id', 255)->nullable()->constrained('organizational_units');// request form

            $table->string('brand', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('serial_number', 255)->nullable();

            $table->string('po_code', 255)->nullable();
            $table->string('po_price', 255)->nullable();
            $table->string('po_date', 255)->nullable();

            // add establishment_id
            $table->string('organization_unit', 255)->nullable();
            $table->timestamp('deliver_date')->nullable();
            $table->boolean('reception_confirmation')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('product_id')->nullable()->constrained('wre_products');
            $table->foreignId('control_id')->nullable()->constrained('wre_controls');
            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('po_id')->nullable()->constrained('arq_purchase_orders');
            $table->foreignId('place_id')->nullable()->constrained('cfg_places');

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
