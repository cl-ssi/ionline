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
        Schema::table('drg_substances', function (Blueprint $table) {
            $table->foreignId('result_id')->after('isp')->nullable()->constrained('drg_substances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drg_substances', function (Blueprint $table) {
            $table->dropForeign(['result_id']);
            $table->dropColumn('result_id');
        });
    }
};
