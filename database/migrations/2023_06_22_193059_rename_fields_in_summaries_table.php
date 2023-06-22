<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldsInSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_summaries', function (Blueprint $table) {
            $table->renameColumn('name', 'subject');
            $table->renameColumn('start_date', 'start_at');
            $table->renameColumn('end_date', 'end_at');
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
            $table->renameColumn('subject', 'name');
            $table->renameColumn('start_at', 'start_date');
            $table->renameColumn('end_at', 'end_date');
        });
    }
}
