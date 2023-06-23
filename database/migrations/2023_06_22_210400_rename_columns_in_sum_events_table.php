<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInSumEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_events', function (Blueprint $table) {
            //
            $table->renameColumn('user', 'require_user');
            $table->renameColumn('file', 'require_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_events', function (Blueprint $table) {
            //
            $table->renameColumn('require_user', 'user');
            $table->renameColumn('require_file', 'file');
        });
    }
}
