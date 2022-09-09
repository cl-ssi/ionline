<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkAreaSpecsToProProgrammingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_items', function (Blueprint $table) {
            $table->string('work_area_specs')->nullable()->after('another_work_area');
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
            $table->dropColumn('work_area_specs');
        });
    }
}
