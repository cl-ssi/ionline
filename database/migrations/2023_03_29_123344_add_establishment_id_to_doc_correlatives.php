<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstablishmentIdToDocCorrelatives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_correlatives', function (Blueprint $table) {
            $table->foreignId('establishment_id')->after('correlative')->default(38)->constrained('establishments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_correlatives', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });
    }
}
