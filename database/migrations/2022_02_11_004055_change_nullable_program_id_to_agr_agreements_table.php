<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableProgramIdToAgrAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id')->nullable()->change();
            $table->dropForeign(['program_id']);
            $table->foreign('program_id')->references('id')->on('agr_programs');
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
            $table->unsignedBigInteger('program_id')->nullable(false)->change();
            $table->dropForeign(['program_id']);
            $table->foreign('program_id')->references('id')->on('agr_programs');
        });
    }
}
