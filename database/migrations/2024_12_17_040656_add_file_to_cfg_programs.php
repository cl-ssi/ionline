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
        Schema::table('cfg_programs', function (Blueprint $table) {
            $table->string('ministerial_resolution_file')->nullable()->after('ministerial_resolution_date');
            $table->string('resource_distribution_file')->nullable()->after('resource_distribution_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cfg_programs', function (Blueprint $table) {
            $table->dropColumn('ministerial_resolution_file');
            $table->dropColumn('resource_distribution_file');
        });
    }
};
