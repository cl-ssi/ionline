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
        Schema::table('frm_purchases_items', function (Blueprint $table) {
            $table->unsignedBigInteger('reception_item_id')->nullable()->after('batch');
            $table->foreign('reception_item_id')->references('id')->on('fin_reception_items')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frm_purchases_items', function (Blueprint $table) {
            $table->dropForeign(['reception_item_id']);
            $table->dropColumn('reception_item_id');
        });
    }
};
