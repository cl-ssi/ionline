<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableActivityItemToProProgrammingActivityItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_activity_item', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_item_id')->nullable()->change();
            $table->dropForeign(['activity_item_id']);
            $table->foreign('activity_item_id')->references('id')->on('pro_activity_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_programming_activity_item', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_item_id')->nullable(false)->change();
            $table->dropForeign(['activity_item_id']);
            $table->foreign('activity_item_id')->references('id')->on('pro_activity_items');
        });
    }
}
