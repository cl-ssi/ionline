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
        Schema::rename('frm_establishments', 'frm_destines');
        Schema::rename('frm_establishments_products', 'frm_destines_products');
        Schema::rename('frm_establishments_users', 'frm_destines_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('frm_destines', 'frm_establishments');
        Schema::rename('frm_destines_products', 'frm_establishments_products');
        Schema::rename('frm_destines_users', 'frm_establishments_users');
    }
};
