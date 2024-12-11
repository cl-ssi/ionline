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
        Schema::create('frm_destines_products', function (Blueprint $table) {
            $table->id();
            $table->integer('stock');
            $table->integer('critic_stock')->nullable();
            $table->integer('max_stock')->nullable();
            $table->foreignId('destiny_id')->constrained('frm_destines');
            $table->foreignId('product_id')->constrained('frm_products');
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
        Schema::dropIfExists('frm_destines_products');
    }
};
