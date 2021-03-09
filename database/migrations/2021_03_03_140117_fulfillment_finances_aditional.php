<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FulfillmentFinancesAditional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table) {
          $table->bigInteger('bill_number')->after('finances_approver_id')->nullable();
          $table->double('total_hours_to_pay', 10, 2)->after('finances_approver_id')->nullable();
          $table->double('total_to_pay', 10, 2)->after('finances_approver_id')->nullable();
          $table->double('total_hours_paid', 10, 2)->after('finances_approver_id')->nullable();
          $table->double('total_paid', 10, 2)->after('finances_approver_id')->nullable();
          $table->datetime('payment_date')->after('finances_approver_id')->nullable();
          $table->integer('contable_month')->after('finances_approver_id')->nullable();
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
          $table->dropColumn('bill_number');
          $table->dropColumn('total_hours_paid');
          $table->dropColumn('total_paid');
          $table->dropColumn('payment_date');
          $table->dropColumn('contable_month');
      });
    }
}
