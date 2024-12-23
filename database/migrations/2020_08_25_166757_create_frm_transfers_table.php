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
        Schema::create('frm_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->cosntrained('frm_destines');
            $table->foreignId('to')->cosntrained('frm_destines');
            $table->foreignId('product_id')->cosntrained('frm_products');
            $table->integer('quantity');
            $table->string('remarks')->nullable();
            $table->foreignId('user_id')->cosntrained('users');
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
        Schema::dropIfExists('frm_transfers');
    }
};
