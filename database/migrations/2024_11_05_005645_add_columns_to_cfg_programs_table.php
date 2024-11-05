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
            $table->unsignedInteger('ministerial_resolution_number')->nullable()->after('is_program');
            $table->date('ministerial_resolution_date')->nullable()->after('ministerial_resolution_number');
            $table->unsignedInteger('resource_distribution_number')->nullable()->after('ministerial_resolution_date');
            $table->date('resource_distribution_date')->nullable()->after('resource_distribution_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cfg_programs', function (Blueprint $table) {
            $table->dropColumn('ministerial_resolution_number');
            $table->dropColumn('ministerial_resolution_date');
            $table->dropColumn('resource_distribution_number');
            $table->dropColumn('resource_distribution_date');
        });
    }
};
