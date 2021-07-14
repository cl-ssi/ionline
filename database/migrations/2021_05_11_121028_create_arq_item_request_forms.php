<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqItemRequestForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_item_request_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('request_form_id');
            $table->foreignId('budget_item_id')->nullable();
            $table->string('article');
            $table->string('unit_of_measurement');
            $table->unsignedInteger('quantity');
            $table->string('unit_value');
            $table->longText('specification');
            $table->string('tax');
            $table->unsignedInteger('expense');

            $table->string('purchase_mechanism')->nullable();
            $table->foreignId('purchase_type_id')->nullable();
            $table->foreignId('purchase_unit_id')->nullable();
            $table->string('id_oc')->nullable();
            $table->string('id_internal_oc')->nullable();
            $table->dateTime('date_oc', $precision = 0)->nullable();
            $table->dateTime('shipping_date_oc', $precision = 0)->nullable();
            $table->string('id_big_buy')->nullable();
            $table->integer('peso_amount')->nullable();
            $table->integer('dollar_amount')->nullable();
            $table->integer('uf_amount')->nullable();
            $table->integer('delivery_term')->nullable();
            $table->dateTime('delivery_date', $precision = 0)->nullable();
            $table->string('id_offer')->nullable();
            $table->string('id_quotation')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('purchase_type_id')->references('id')->on('cfg_purchase_types');
            $table->foreign('purchase_unit_id')->references('id')->on('cfg_purchase_units');

            $table->foreign('request_form_id')->references('id')->on('arq_request_forms');
            $table->foreign('budget_item_id')->references('id')->on('arq_budget_items');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_item_request_forms');
    }
}
