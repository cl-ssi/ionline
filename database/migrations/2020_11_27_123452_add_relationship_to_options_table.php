<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psi_options', function (Blueprint $table) {
            //
            $table->foreignId('question_id');
            $table->foreign('question_id')->references('id')->on('psi_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            //
            $table->dropForeign(['question_id']);
            $table->dropColumn('question_id');
        });
    }
}
