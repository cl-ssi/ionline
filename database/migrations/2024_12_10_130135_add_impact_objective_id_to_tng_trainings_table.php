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
        Schema::table('tng_trainings', function (Blueprint $table) {
            $table->foreignId('impact_objective_id')->after('strategic_axes_id')->nullable()->constrained('tng_impact_objectives');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tng_trainings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('impact_objective_id');
        });
    }
};
