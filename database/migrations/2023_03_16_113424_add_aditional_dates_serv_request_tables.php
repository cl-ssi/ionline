<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAditionalDatesServRequestTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            $table->dateTime('has_resolution_file_at')->nullable()->after('has_resolution_file');
        });

        Schema::table('doc_fulfillments', function (Blueprint $table) {
            $table->dateTime('total_to_pay_at')->nullable()->after('total_to_pay');
            $table->dateTime('has_invoice_file_at')->nullable()->after('has_invoice_file');
            $table->foreignId('has_invoice_file_user_id')->nullable()->constrained('users')->after('has_invoice_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table) {
            $table->dropColumn('total_to_pay_at');
            $table->dropColumn('has_invoice_file_at');
            $table->dropColumn('has_invoice_file_user_id');
        });

        Schema::table('doc_service_requests', function (Blueprint $table) {
            $table->dropColumn('has_resolution_file_at');
        });
    }
}
