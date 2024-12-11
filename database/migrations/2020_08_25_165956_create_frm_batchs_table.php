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
        Schema::create('frm_batchs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('frm_products');
            $table->dateTime('due_date'); //fecha vencimiento
            $table->string('batch');
            $table->integer('count');
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
        Schema::dropIfExists('frm_batchs');
    }
};
