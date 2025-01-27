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
        Schema::table('agr_process_types', function (Blueprint $table) {
            $table->boolean('revision_commune')->default(false)->after('bilateral');
            $table->boolean('sign_commune')->default(false)->after('bilateral');
        });
        Schema::table('agr_process_types', function (Blueprint $table) {
            $table->dropColumn('bilateral');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agr_process_types', function (Blueprint $table) {
            $table->boolean('bilateral')->default(false)->after('sign_commune');
        });
        Schema::table('agr_process_types', function (Blueprint $table) {
            $table->dropColumn('revision_commune');
            $table->dropColumn('sign_commune');
        });
    }
};
