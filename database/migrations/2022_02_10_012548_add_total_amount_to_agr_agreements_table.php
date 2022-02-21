<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalAmountToAgrAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->integer('total_amount')->nullable()->after('quotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
    }
}
