<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetItemToRstRequestReplacementStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->foreignId('budget_item_id')->after('request_id')->nullable()->constrained('cfg_budget_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->dropForeign(['budget_item_id']);
            $table->dropColumn(['budget_item_id']);
        });
    }
}
