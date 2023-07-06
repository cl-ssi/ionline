<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableSumLinksToSumEventLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_links', function (Blueprint $table) {
            //
            Schema::rename('sum_links', 'sum_event_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_links', function (Blueprint $table) {
            //
            Schema::rename('sum_event_links', 'sum_links');
        });
    }
}
