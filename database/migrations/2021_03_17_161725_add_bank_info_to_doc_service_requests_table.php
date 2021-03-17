<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankInfoToDocServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            //
            $table->foreignId('bank_id')->after('payment_date')->nullable();
            $table->foreign('bank_id')->references('id')->on('cfg_banks');
            $table->string('pay_method')->after('bank_id')->nullable();
            $table->string('account_type')->after('pay_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            //
            $table->dropForeign(['bank_id']);
            $table->dropColumn('bank_id');
            $table->dropColumn('pay_method');
            $table->dropColumn('account_type');
        });
    }
}
