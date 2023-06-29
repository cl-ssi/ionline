<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInSumSummaryEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_summary_events', function (Blueprint $table) {
            //
            $table->renameColumn('event_id', 'event_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_summary_events', function (Blueprint $table) {
            //
            $table->renameColumn('event_type_id', 'event_id');
        });
    }
}
