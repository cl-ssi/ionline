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
            $table->softDeletes();
            $table->timestamps();
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
