<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationToProProgrammingActivityItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_activity_item', function (Blueprint $table) {
            $table->text('observation')->nullable()->after('requested_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_programming_activity_item', function (Blueprint $table) {
            $table->dropColumn('observation');
        });
    }
}
