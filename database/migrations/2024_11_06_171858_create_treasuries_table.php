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
        Schema::create('fin_treasuries', function (Blueprint $table) {
            $table->id();
            $table->datetime('bank_receipt_date')->nullable();
            $table->string('bank_receipt_file')->nullable();
            $table->datetime('third_parties_date')->nullable();
            $table->string('third_parties_file')->nullable();
            $table->nullableMorphs('treasureable');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_treasuries');
    }
};
