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
        Schema::table('fin_treasuries', function (Blueprint $table) {
            $table->string('description')->after('name')->nullable();
            $table->string('resolution_folio')->after('description')->nullable();
            $table->datetime('resolution_date')->after('resolution_folio')->nullable();
            $table->string('resolution_file')->after('resolution_date')->nullable();
            $table->string('commitment_folio_sigfe')->after('resolution_file')->nullable();
            $table->datetime('commitment_date_sigfe')->after('commitment_folio_sigfe')->nullable();
            $table->string('commitment_file_sigfe')->after('commitment_date_sigfe')->nullable();
            $table->string('accrual_folio_sigfe')->after('commitment_file_sigfe')->nullable();
            $table->datetime('accrual_date_sigfe')->after('accrual_folio_sigfe')->nullable();
            $table->string('accrual_file_sigfe')->after('accrual_date_sigfe')->nullable();
            $table->datetime('bank_receipt_date')->after('accrual_file_sigfe')->nullable();
            $table->string('bank_receipt_file')->after('bank_receipt_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fin_treasuries', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('resolution_folio');
            $table->dropColumn('resolution_date');
            $table->dropColumn('resolution_file');
            $table->dropColumn('commitment_folio_sigfe');
            $table->dropColumn('commitment_date_sigfe');
            $table->dropColumn('commitment_file_sigfe');
            $table->dropColumn('accrual_folio_sigfe');
            $table->dropColumn('accrual_date_sigfe');
            $table->dropColumn('accrual_file_sigfe');
            $table->dropColumn('bank_receipt_date');
            $table->dropColumn('bank_receipt_file');
        });
    }
};
