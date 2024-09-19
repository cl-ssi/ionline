<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pro_programming_item_pro_hour', function (Blueprint $table) {
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY direct_work_year DOUBLE(15,8) NULL DEFAULT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pro_programming_item_pro_hour', function (Blueprint $table) {
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY direct_work_year DOUBLE(8,2) NULL DEFAULT NULL;');
        });
    }
};
