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
            $table->foreignId('sended_revision_lawyer_user_id')->nullable()->after('sended_revision_lawyer_at')->constrained('users');
            $table->foreignId('sended_revision_commune_user_id')->nullable()->after('sended_revision_commune_at')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agr_processes', function (Blueprint $table) {
            $table->dropForeign(['sended_revision_lawyer_user_id']);
            $table->dropForeign(['sended_revision_commune_user_id']);
        });
    }
};
