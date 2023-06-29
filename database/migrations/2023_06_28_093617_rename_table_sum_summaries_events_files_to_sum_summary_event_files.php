<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableSumSummariesEventsFilesToSumSummaryEventFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_summaries_events_files', function (Blueprint $table) {
            //
            Schema::rename('sum_summaries_events_files', 'sum_summary_event_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_summaries_events_files', function (Blueprint $table) {
            //
            Schema::rename('sum_summary_event_files', 'sum_summaries_events_files');
        });
    }
}
