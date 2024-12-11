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
        Schema::create('drg_protocols', function (Blueprint $table) {
            $table->id('id');
            $table->smallInteger('sample');
            $table->enum('result', ['Positivo', 'Negativo']);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('reception_item_id')->constrained('drg_reception_items');
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
        Schema::dropIfExists('drg_protocols');
    }
};
