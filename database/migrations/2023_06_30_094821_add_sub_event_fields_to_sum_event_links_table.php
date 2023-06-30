<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubEventFieldsToSumEventLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_event_links', function (Blueprint $table) {
            //
            $table->boolean('before_sub_event')->nullable()->after('before_event_id');
            $table->boolean('after_sub_event')->nullable()->after('after_event_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_event_links', function (Blueprint $table) {
            //
            $table->dropColumn('before_sub_event');
            $table->dropColumn('after_sub_event');
        });
    }
}
