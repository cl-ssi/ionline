<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtypeIndirectActivitiesFieldsToProProgrammingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_items', function (Blueprint $table) {
            $table->string('activity_subtype')->nullable()->after('activity_type');
            $table->string('activity_category')->nullable()->after('activity_subtype');
            $table->integer('times_month')->nullable()->after('concentration');
            $table->integer('months_year')->nullable()->after('times_month');
            $table->string('work_area')->nullable()->after('months_year');
            $table->string('another_work_area')->nullable()->after('work_area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_programming_items', function (Blueprint $table) {
            $table->dropColumn(['activity_subtype','activity_category','times_month','months_year','work_area','another_work_area']);
        });
    }
}
