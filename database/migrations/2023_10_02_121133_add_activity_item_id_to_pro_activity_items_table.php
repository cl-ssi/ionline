<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('pro_activity_items', function (Blueprint $table) {
            $table->foreignId('activity_item_id')->nullable()->after('activity_id')->constrained('pro_activity_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_activity_items', function (Blueprint $table) {
            $table->dropForeign(['activity_item_id']);
            $table->dropColumn('activity_item_id');
        });
    }
};
