<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBooleanFieldsToSumEvents extends Migration
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
            $table->boolean('start')->after('file')->nullable();
            $table->boolean('end')->after('start')->nullable();
            $table->boolean('investigator')->after('end')->nullable();
            $table->boolean('actuary')->after('investigator')->nullable();
            $table->boolean('repeat')->after('actuary')->nullable();
            $table->tinyinteger('num_repeat')->after('repeat')->unsigned()->nullable();
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
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->dropColumn('investigator');
            $table->dropColumn('actuary');
            $table->dropColumn('repeat');
            $table->dropColumn('num_repeat');
        });
    }
}
