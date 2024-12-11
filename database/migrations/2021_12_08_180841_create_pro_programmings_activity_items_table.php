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
        Schema::create('pro_programming_activity_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programming_id')->constrained('pro_programmings');
            $table->foreignId('activity_item_id')->nullable()->constrained('pro_activity_items');
            $table->foreignId('requested_by')->constrained('users');
            $table->text('observation')->nullable();
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
        Schema::dropIfExists('pro_programmings_activity_items');
    }
};
