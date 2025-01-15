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
        Schema::table('doc_service_requests', function (Blueprint $table) {
            $table->foreignId('policy_establishment_id')->after('month_of_payment')->nullable()->constrained('establishments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            $table->dropColumn('policy_establishment_id');
        });
    }
};
