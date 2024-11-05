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
        Schema::table('rst_selected_positions', function (Blueprint $table) {
            $table->date('start_date')->after('position_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rst_selected_positions', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }
};
