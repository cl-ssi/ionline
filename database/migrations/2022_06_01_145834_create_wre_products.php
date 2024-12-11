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
        Schema::create('wre_products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable(); // TODO: El campo pudiera llamarse description
            $table->string('barcode', 255)->nullable();

            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('category_id')->nullable()->constrained('wre_categories');
            $table->foreignId('unspsc_product_id')->nullable()->constrained('unspsc_products');

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
        Schema::dropIfExists('wre_products');
    }
};
