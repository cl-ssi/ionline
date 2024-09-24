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
        Schema::table('frm_deliveries', function (Blueprint $table) {
            $table->renameColumn('establishment_id', 'destiny_id');
        });

        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->renameColumn('establishment_id', 'destiny_id');
        });

        Schema::table('frm_destines_products', function (Blueprint $table) {
            $table->renameColumn('establishment_id', 'destiny_id');
        });

        Schema::table('frm_destines_users', function (Blueprint $table) {
            $table->renameColumn('establishment_id', 'destiny_id');
        });

        Schema::table('frm_receivings', function (Blueprint $table) {
            $table->renameColumn('establishment_id', 'destiny_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frm_deliveries', function (Blueprint $table) {
            $table->renameColumn('destiny_id', 'establishment_id');
        });

        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->renameColumn('destiny_id', 'establishment_id');
        });

        Schema::table('frm_destines_products', function (Blueprint $table) {
            $table->renameColumn('destiny_id', 'establishment_id');
        });

        Schema::table('frm_destines_users', function (Blueprint $table) {
            $table->renameColumn('destiny_id', 'establishment_id');
        });

        Schema::table('frm_receivings', function (Blueprint $table) {
            $table->renameColumn('destiny_id', 'establishment_id');
        });
    }
};
