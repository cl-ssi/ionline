<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetItemIdToArqPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_passengers', function (Blueprint $table) {
            $table->foreignId('budget_item_id')->nullable()->after('request_form_id')->constrained('cfg_budget_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_passengers', function (Blueprint $table) {
            $table->dropForeign(['budget_item_id']);
            $table->dropColumn(['budget_item_id']);
        });
    }
}
