<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqItemChangedRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_item_changed_request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_request_form_id');
            $table->foreignId('budget_item_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->string('article')->nullable();
            $table->string('unit_of_measurement')->nullable();
            $table->float('quantity')->nullable();
            $table->string('article_file')->nullable();
            $table->float('unit_value', 15, 2)->nullable();
            $table->longText('specification')->nullable();
            $table->string('tax')->nullable();
            $table->float('expense', 15, 2)->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_request_form_id')->references('id')->on('arq_item_request_forms');
            $table->foreign('budget_item_id')->references('id')->on('cfg_budget_items');
            $table->foreign('product_id')->references('id')->on('unspsc_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_item_changed_request_forms');
    }
}
