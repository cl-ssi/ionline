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
        Schema::create('frm_products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->string('unit');
            $table->date('expiration')->nullable();
            //$table->string('batch')->nullable();
            $table->integer('price')->nullable();
            $table->integer('stock');
            $table->integer('critic_stock')->nullable();
            $table->string('min_stock')->nullable();
            $table->string('max_stock')->nullable();
            $table->longText('storage_conditions')->nullable();
            //$table->string('category');
            //$table->string('program')->nullable();
            //$table->integer('valued'); On the fly
            $table->foreignId('pharmacy_id')->nullable()->constrained('frm_pharmacies');
            $table->foreignId('category_id')->nullable()->constrained('frm_categories');
            $table->foreignId('program_id')->nullable()->constrained('frm_programs');
            $table->string('experto_id')->nullable();
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
        Schema::dropIfExists('frm_products');
    }
};
