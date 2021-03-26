<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorityToAgrAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->integer('authority_id')->after('commune_id')->unsigned()->nullable();
            $table->foreign('authority_id')->references('id')->on('rrhh_authorities');
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
            $table->dropForeign(['agr_agreements_authority_id_foreign']);
            $table->dropColumn('authority_id');
        });
    }
}
