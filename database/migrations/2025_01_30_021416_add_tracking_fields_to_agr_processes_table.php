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
        Schema::table('agr_processes', function (Blueprint $table) {
            // sended_to_layer_at
            $table->dateTime('sended_revision_lawyer_at')->nullable()->after('previous_process_id');
            // sended_to_commune_at
            $table->dateTime('sended_revision_commune_at')->nullable()->after('revision_by_lawyer_user_id');
            // sended endorses_at
            $table->dateTime('sended_endorses_at')->nullable()->after('revision_by_commune_user_id');
            // resolution_id constrained to agr_processes
            $table->foreignId('resolution_id')->nullable()->after('returned_from_commune_at')->constrained('agr_processes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agr_processes', function (Blueprint $table) {
            $table->dropColumn('sended_revision_lawyer_at');
            $table->dropColumn('sended_revision_commune_at');
            $table->dropColumn('sended_endorses_at');
            $table->dropForeign(['resolution_id']);
            $table->dropColumn('resolution_id');
        });
    }
};
