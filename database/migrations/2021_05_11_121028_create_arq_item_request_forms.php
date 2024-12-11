<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * not_available:  no disponible por parte del oferente
     * timed_out: caducado, excedido tiempo transcurrido según ley
     * desert: no se encuentra en el mercado
     * partial: entrega Parcial
     * total: entrega total
     * in_progress: en progreso
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_item_request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_form_id')->constrained('arq_request_forms');
            $table->foreignId('budget_item_id')->nullable()->constrained('cfg_budget_items');
            $table->foreignId('product_id')->nullable()->constrained('unspsc_products');
            $table->string('article', 255)->nullable();
            $table->string('unit_of_measurement');
            $table->float('quantity');
            $table->string('article_file')->nullable();
            $table->float('unit_value', 15, 2);
            $table->longText('specification');
            $table->string('tax');
            $table->float('expense', 15, 2);
            $table->enum('status', ['in_progress', 'total', 'partial', 'desert',  'timed_out', 'not_available']);
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
        Schema::dropIfExists('arq_item_request_forms');
    }
};
