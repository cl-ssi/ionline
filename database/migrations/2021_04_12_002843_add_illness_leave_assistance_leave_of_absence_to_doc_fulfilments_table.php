<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIllnessLeaveAssistanceLeaveOfAbsenceToDocFulfilmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table) {
            //
            $table->boolean('illness_leave')->after('bill_number')->nullable();
            $table->boolean('leave_of_absence')->after('illness_leave')->nullable();
            $table->boolean('assistance')->after('leave_of_absence')->nullable();
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
            //
            $table->boolean('illness_leave')->nullable();
            $table->boolean('leave_of_absence')->nullable();
            $table->boolean('assistance')->nullable();
        });
    }
}
