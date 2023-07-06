<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableSumSummariesEventsToSumSummaryEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_summaries_events', function (Blueprint $table) {
            //
            Schema::rename('sum_summaries_events', 'sum_summary_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_summaries_events', function (Blueprint $table) {
            //
            Schema::rename('sum_summary_events', 'sum_summaries_events');
        });
    }
}
