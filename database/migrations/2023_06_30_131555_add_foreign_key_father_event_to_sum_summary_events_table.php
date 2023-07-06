<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyFatherEventToSumSummaryEventsTable extends Migration
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
            $table->foreignId('father_event_id')->after('creator_id')->nullable()->constrained('sum_summary_events');
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
            $table->dropForeign(['father_event_id']);
            $table->dropColumn('father_event_id');
        });
    }
}
