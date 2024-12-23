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
        Schema::create('arq_item_changed_request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_request_form_id')->constrained('arq_item_request_forms');
            $table->foreignId('budget_item_id')->nullable()->constrained('cfg_budget_items');
            $table->foreignId('product_id')->nullable()->constrained('unspsc_products');
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
};
