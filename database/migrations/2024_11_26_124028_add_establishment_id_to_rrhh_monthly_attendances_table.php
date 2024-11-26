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
        Schema::table('rrhh_monthly_attendances', function (Blueprint $table) {
            $table->foreignId('establishment_id')->after('report_date')->default(38)->constrained('establishments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rrhh_monthly_attendances', function (Blueprint $table) {
            $table->dropConstrainedForeignId('establishment_id');
        });
    }
};
