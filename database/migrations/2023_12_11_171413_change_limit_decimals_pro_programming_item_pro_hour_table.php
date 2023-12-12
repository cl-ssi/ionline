<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_item_pro_hour', function (Blueprint $table) {
            $table->decimal('activity_performance', 7, 1)->nullable()->change();
            $table->decimal('designated_hours_weeks', 7, 1)->nullable()->change();
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY hours_required_year DOUBLE(8,2) NULL DEFAULT NULL;');
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY hours_required_day DOUBLE(8,2) NULL DEFAULT NULL;');
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY direct_work_year DOUBLE(8,2) NULL DEFAULT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_programming_item_pro_hour', function (Blueprint $table) {
            $table->decimal('activity_performance',5,1)->nullable()->change();
            $table->decimal('designated_hours_weeks',5,1)->nullable()->change();
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY hours_required_year DOUBLE(5,2) NULL DEFAULT NULL;');
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY hours_required_day DOUBLE(5,2) NULL DEFAULT NULL;');
            DB::statement('ALTER TABLE pro_programming_item_pro_hour MODIFY direct_work_year DOUBLE(5,2) NULL DEFAULT NULL;');   
        });
    }
};
