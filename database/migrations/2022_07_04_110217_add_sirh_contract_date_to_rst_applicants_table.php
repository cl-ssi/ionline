<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSirhContractDateToRstApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_applicants', function (Blueprint $table) {
            $table->date('sirh_contract')->nullable()->after('replacement_reason');
        });

        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->boolean('sirh_contract')->nullable()->after('request_status');
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
            $table->dropColumn('sirh_contract');
        });

        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->dropColumn('sirh_contract');
        });
    }
}
