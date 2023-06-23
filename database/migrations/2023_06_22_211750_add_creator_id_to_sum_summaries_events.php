<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorIdToSumSummariesEvents extends Migration
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
            $table->foreignId('creator_id')->after('summary_id')->nullable()->constrained('users');
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
            $table->dropForeign(['creator_id']);
            $table->dropColumn('creator_id');
        });
    }
}
