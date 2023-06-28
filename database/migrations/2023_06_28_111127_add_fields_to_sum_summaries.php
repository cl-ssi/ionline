<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSumSummaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sum_summaries', function (Blueprint $table) {
            //
            $table->tinyInteger('resolution_number')->nullable()->after('status');
            $table->date('resolution_date')->nullable()->after('resolution_number');
            $table->string('type')->nullable()->after('resolution_date');

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
            //
            $table->dropColumn('resolution_number');
            $table->dropColumn('resolution_date');
            $table->dropColumn('type');
        });
    }
}
