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
        Schema::create('wre_control_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->nullable();
            $table->integer('balance')->nullable();
            $table->boolean('confirm')->nullable();
            $table->integer('correlative_po')->nullable();
            $table->boolean('inventory')->nullable();
            $table->decimal('unit_price', 16, 2);
            $table->foreignId('control_id')->nullable()->constrained('wre_controls');
            $table->foreignId('program_id')->nullable()->constrained('cfg_programs');
            $table->foreignId('product_id')->nullable()->constrained('wre_products');
            $table->foreignId('unit_id')->nullable()->constrained('wre_units');
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
        Schema::dropIfExists('wre_control_items');
    }
};
