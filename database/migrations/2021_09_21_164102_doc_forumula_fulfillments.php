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
        Schema::create('doc_formula_fulfillments', function (Blueprint $table) {
            $table->foreignId('doc_formula_id')->constrained('doc_denominations_formula')->onDelete('cascade');
            $table->foreignId('doc_fulfillments_id')->constrained('doc_fulfillments')->onDelete('cascade');
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
        Schema::dropIfExists('doc_denominations_formula_fulfillments');
    }
};
