<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psi_results', function (Blueprint $table) {
            //
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('request_id');
            $table->foreign('request_id')->references('id')->on('psi_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('psi_results', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['request_id']);
            $table->dropColumn('request_id');
        });
    }
}
