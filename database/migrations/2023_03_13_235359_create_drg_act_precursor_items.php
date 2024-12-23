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
        Schema::create('drg_act_precursor_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reception_item_id')->nullable()->constrained('drg_reception_items');
            $table->foreignId('act_precursor_id')->nullable()->constrained('drg_act_precursors');

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
        Schema::dropIfExists('drg_act_precursor_items');
    }
};
