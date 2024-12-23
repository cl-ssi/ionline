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
        Schema::create('frm_inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('inventory_adjustment_type_id')->constrained('frm_inventory_adjustment_types');
            $table->foreignId('pharmacy_id')->constrained('frm_pharmacies');
            $table->foreignId('user_id')->constrained('users');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('frm_inventory_adjustments');
    }
};
