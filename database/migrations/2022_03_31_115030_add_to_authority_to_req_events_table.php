<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToAuthorityToReqEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_events', function (Blueprint $table) {
            $table->boolean('to_authority')->nullable()->after('requirement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_events', function (Blueprint $table) {
            $table->dropColumn('to_authority');
        });
    }
}
