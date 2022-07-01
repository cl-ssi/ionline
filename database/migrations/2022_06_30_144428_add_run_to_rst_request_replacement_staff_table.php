<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRunToRstRequestReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->unsignedInteger('run')->nullable()->after('name_to_replace');
            $table->char('dv',1)->nullable()->after('run');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->dropColumn('run');
            $table->dropColumn('dv');
        });
    }
}
