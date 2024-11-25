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
        Schema::create('fin_accountancies', function (Blueprint $table) {
            $table->id();
            $table->string('resolution_folio')->nullable();
            $table->datetime('resolution_date')->nullable();
            $table->string('resolution_file')->nullable();
            $table->string('commitment_folio_sigfe')->nullable();
            $table->datetime('commitment_date_sigfe')->nullable();
            $table->string('commitment_file_sigfe')->nullable();
            $table->string('accrual_folio_sigfe')->nullable();
            $table->datetime('accrual_date_sigfe')->nullable();
            $table->string('accrual_file_sigfe')->nullable();
            $table->nullableMorphs('accountable');
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
        Schema::dropIfExists('fin_accountancies');
    }
};
