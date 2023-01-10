<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToRemFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rem_files', function (Blueprint $table) {
            $table->string('type')
            ->nullable()
            ->after('rem_period_series_id');
    });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rem_files', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
