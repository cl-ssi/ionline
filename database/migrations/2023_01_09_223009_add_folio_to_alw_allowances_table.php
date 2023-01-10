<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFolioToAlwAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alw_allowances', function (Blueprint $table) {
            $table->string('folio_sirh')->after('id')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alw_allowances', function (Blueprint $table) {
            $table->dropColumn('folio_sirh');
        });
    }
}
