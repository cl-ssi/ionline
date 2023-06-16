<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_summaries', function (Blueprint $table) {
            //
            $table->timestamp('start_date')->nullable()->after('status');
            $table->timestamp('end_date')->nullable()->after('start_date');
            $table->text('observation')->nullable()->after('end_date');
            $table->foreignId('investigator_id')->after('observation')->nullable()->constrained('users');
            $table->foreignId('actuary_id')->after('investigator_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_summaries', function (Blueprint $table) {
            //
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('observation');

            $table->dropForeign(['investigator_id']);
            $table->dropColumn('investigator_id');
            $table->dropForeign(['actuary_id']);
            $table->dropColumn('actuary_id');

        });
    }
}
