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
        Schema::table('agr_processes', function (Blueprint $table) {
            $table->date('document_date')->nullable()->after('document_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agr_processes', function (Blueprint $table) {
            $table->dropColumn('document_date');
        });
    }
};
