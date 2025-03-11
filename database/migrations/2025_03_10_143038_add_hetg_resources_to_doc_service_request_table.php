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
            $table->boolean('hetg_resources')->default(false)->after('signed_budget_availability_cert_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            $table->dropColumn('hetg_resources');
        });
    }
};
