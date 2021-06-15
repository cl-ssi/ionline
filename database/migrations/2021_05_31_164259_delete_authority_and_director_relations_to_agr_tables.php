<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteAuthorityAndDirectorRelationsToAgrTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->dropForeign(['authority_id']);
            $table->dropColumn('authority_id');
        });

        Schema::table('agr_addendums', function (Blueprint $table) {
            $table->dropForeign(['director_id']);
            $table->dropColumn(['director_id', 'director_appellative', 'director_decree']);
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
            $table->foreignId('authority_id')->after('commune_id')->nullable();
            $table->foreign('authority_id')->references('id')->on('rrhh_authorities');
        });

        Schema::table('agr_addendums', function (Blueprint $table) {
            $table->foreignId('director_id')->after('director_signer_id')->nullable();
            $table->foreign('director_id')->references('id')->on('users');
            $table->string('director_appellative')->after('director_id')->nullable();
            $table->string('director_decree')->after('director_appellative')->nullable();
        });
    }
}
