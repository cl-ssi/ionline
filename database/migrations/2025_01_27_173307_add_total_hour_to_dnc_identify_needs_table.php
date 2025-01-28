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
        Schema::table('dnc_identify_needs', function (Blueprint $table) {
            $table->float('total_hours', 6, 2)->after('subject')->nullable();
            $table->float('activity_value', 15, 2)->after('accommodation_price')->nullable();
            $table->float('total_value', 15, 2)->after('activity_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dnc_identify_needs', function (Blueprint $table) {
            $table->dropColumn('total_hours');
            $table->dropColumn('activity_value');
            $table->dropColumn('total_value');
        });
    }
};
