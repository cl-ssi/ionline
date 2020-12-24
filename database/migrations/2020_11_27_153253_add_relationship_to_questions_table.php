<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psi_questions', function (Blueprint $table) {
            //
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('psi_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('psi_questions', function (Blueprint $table) {
            //
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
