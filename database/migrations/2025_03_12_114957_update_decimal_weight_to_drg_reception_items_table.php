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
        Schema::table('drg_reception_items', function (Blueprint $table) {
            $table->decimal('document_weight', 12, 3)->nullable()->change();
            $table->decimal('gross_weight', 12, 3)->nullable()->change();
            $table->decimal('net_weight', 12, 3)->nullable()->change();
            $table->decimal('estimated_net_weight', 12, 3)->nullable()->change();
            $table->decimal('destruct', 12, 3)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drg_reception_items', function (Blueprint $table) {
            $table->decimal('document_weight', 10, 3)->nullable()->change();
            $table->decimal('gross_weight', 10, 3)->nullable()->change();
            $table->decimal('net_weight', 10, 3)->nullable()->change();
            $table->decimal('estimated_net_weight', 10, 3)->nullable()->change();
            $table->decimal('destruct', 10, 3)->nullable()->change();
        });
    }
};
