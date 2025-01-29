<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dnc_annual_budgets', function (Blueprint $table) {
            $table->id();

            $table->string('period')->nullable();
            $table->string('law')->nullable();
            $table->string('item')->nullable();
            $table->float('budget', 15, 2)->nullable();
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnc_annual_budgets');
    }
};
