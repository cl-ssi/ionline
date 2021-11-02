<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationProgramResolutionToAgrAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_amounts', function (Blueprint $table) {
            $table->foreignId('program_resolution_id')->nullable()->after('agreement_id');
            $table->foreign('program_resolution_id')->references('id')->on('agr_program_resolutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agr_amounts', function (Blueprint $table) {
            $table->dropForeign(['program_resolution_id']);
            $table->dropColumn('program_resolution_id');
        });
    }
}
