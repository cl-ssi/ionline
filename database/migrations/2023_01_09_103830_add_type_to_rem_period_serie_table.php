<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToRemPeriodSerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rem_period_series', function (Blueprint $table) {
            $table->string('type')
                ->nullable()
                ->after('serie_id');            
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rem_period_series', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
