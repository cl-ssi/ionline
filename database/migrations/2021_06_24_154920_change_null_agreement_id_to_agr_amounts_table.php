<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullAgreementIdToAgrAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_amounts', function (Blueprint $table) {
            $table->bigInteger('agreement_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agr_amounts', function (Blueprint $table) {
            $table->bigInteger('agreement_id')->unsigned()->nullable(false)->change();
        });
    }
}
