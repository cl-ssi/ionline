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
        Schema::create('ppl_purchase_plan_items', function (Blueprint $table) {
            $table->id();

            $table->string('article')->nullable();
            $table->string('unit_of_measurement')->nullable();
            $table->float('quantity')->nullable();
            $table->string('article_file')->nullable();
            $table->float('unit_value', 15, 2)->nullable();
            $table->longText('specification')->nullable();
            $table->string('tax')->nullable();
            $table->float('expense', 15, 2)->nullable();

            $table->string('january')->nullable();
            $table->string('february')->nullable();
            $table->string('march')->nullable();
            $table->string('april')->nullable();
            $table->string('may')->nullable();
            $table->string('june')->nullable();
            $table->string('july')->nullable();
            $table->string('august')->nullable();
            $table->string('september')->nullable();
            $table->string('october')->nullable();
            $table->string('november')->nullable();
            $table->string('december')->nullable();

            $table->foreignId('unspsc_product_id')->nullable()->constrained('unspsc_products');
            $table->foreignId('purchase_plan_id')->nullable()->constrained('ppl_purchase_plans');

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
        Schema::dropIfExists('ppl_purchase_plan_items');
    }
};
