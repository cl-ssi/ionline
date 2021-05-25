<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToAgrAddendumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_addendums', function (Blueprint $table) {
            $table->integer('number')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->renameColumn('file', 'res_file');
            $table->renameColumn('number', 'res_number');
            $table->renameColumn('date', 'res_date');
            $table->date('date')->after('id')->nullable();
            $table->string('file')->after('date')->nullable();
            $table->foreignId('file_to_endorse_id')->after('agreement_id')->nullable();
            $table->foreign('file_to_endorse_id')->references('id')->on('doc_signatures_files');
            $table->foreignId('file_to_sign_id')->after('file_to_endorse_id')->nullable();
            $table->foreign('file_to_sign_id')->references('id')->on('doc_signatures_files');
            $table->foreignId('referrer_id')->after('file_to_sign_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->foreignId('director_id')->after('referrer_id')->nullable();
            $table->foreign('director_id')->references('id')->on('users');
            $table->string('director_appellative')->after('director_id')->nullable();
            $table->string('director_decree')->after('director_appellative')->nullable();
            $table->string('representative')->after('director_decree')->nullable();
            $table->string('representative_rut')->after('representative')->nullable();
            $table->string('representative_appellative')->after('representative_rut')->nullable();
            $table->string('representative_decree')->after('representative_appellative')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agr_addendums', function (Blueprint $table) {
            $table->dropForeign(['file_to_endorse_id', 'file_to_sign_id', 'referrer_id', 'director_id']);
            $table->dropColumn(['file_to_endorse_id', 'file_to_sign_id', 'referrer_id', 'director_id', 'director_appellative', 'director_decree', 'representative', 'representative_rut', 'representative_appellative', 'representative_decree', 'date', 'file']);
            $table->integer('res_number')->nullable(false)->change();
            $table->date('res_date')->nullable(false)->change();
            $table->renameColumn('res_file', 'file');
            $table->renameColumn('res_number', 'number');
        });
    }
}
