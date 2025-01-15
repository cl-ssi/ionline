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
        Schema::table('cfg_approval_flows', function (Blueprint $table) {
            $table->string('parameter')->after('class')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cfg_approval_flows', function (Blueprint $table) {
            $table->dropColumn('parameter');
        });
    }
};
