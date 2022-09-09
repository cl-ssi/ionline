<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesignatedHoursWeeksToProProgrammingItemProHourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_item_pro_hour', function (Blueprint $table) {
            $table->decimal('designated_hours_weeks',5,1)->nullable()->after('activity_performance');
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
            $table->dropColumn('designated_hours_weeks');
        });
    }
}
