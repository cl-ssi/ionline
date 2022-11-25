<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnviromentToCfgAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_access_logs', function (Blueprint $table) {
            $table->string('enviroment')->nullable()->after('switch_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_access_logs', function (Blueprint $table) {
            $table->dropColumn('enviroment');
        });
    }
}
