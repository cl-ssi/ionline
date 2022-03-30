<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToAuthorityToReqRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_requirements', function (Blueprint $table) {
            $table->boolean('to_authority')->nullable()->after('group_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_requirements', function (Blueprint $table) {
            $table->dropColumn('to_authority');
        });
    }
}
