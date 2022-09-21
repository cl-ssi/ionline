<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequesterIdToRstRequestReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->foreignId('requester_id')->after('organizational_unit_id')->nullable();
            $table->foreignId('requester_ou_id')->after('requester_id')->nullable();

            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('requester_ou_id')->references('id')->on('organizational_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->dropColumn(['requester_id']);
            $table->dropColumn(['requester_ou_id']);
        });
    }
}
