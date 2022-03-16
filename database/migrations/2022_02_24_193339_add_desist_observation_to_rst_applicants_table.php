<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesistObservationToRstApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_applicants', function (Blueprint $table) {
            $table->longText('desist_observation')->nullable()->after('desist');
            $table->string('reason')->nullable()->after('desist_observation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_applicants', function (Blueprint $table) {
            $table->dropColumn('desist_observation');
            $table->dropColumn('reason');
        });
    }
}
