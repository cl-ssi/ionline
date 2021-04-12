<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetAvailabilityCertToDocServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            $table->foreignId('signed_budget_availability_cert_id')->after('user_id')->nullable();
            $table->foreign('signed_budget_availability_cert_id')->references('id')->on('doc_signatures_files');
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
            $table->dropForeign(['signed_budget_availability_cert_id']);
            $table->dropColumn('signed_budget_availability_cert_id');
        });
    }
}
