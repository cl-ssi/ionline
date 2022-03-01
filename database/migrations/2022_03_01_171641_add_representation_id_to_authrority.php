<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRepresentationIdToAuthrority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_authorities', function (Blueprint $table) {
            $table->foreignId('representation_id')->after('creator_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_authorities', function (Blueprint $table) {
            $table->dropForeign(['representation_id']);
            $table->dropColumn('representation_id');
        });
    }
}
