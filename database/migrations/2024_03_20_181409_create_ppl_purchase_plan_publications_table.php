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
        Schema::create('ppl_purchase_plan_publications', function (Blueprint $table) {
            $table->id();

            $table->string('mercado_publico_id')->nullable();
            $table->date('date')->nullable();
            $table->string('file')->nullable();

            $table->foreignId('purchase_plan_id')->nullable()->constrained('ppl_purchase_plans');
            $table->foreignId('user_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('ppl_purchase_plan_publications');
    }
};
