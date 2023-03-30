<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendImputedLenghtToDrgReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drg_receptions', function (Blueprint $table) {
            $table->string('imputed',512)->change();
            $table->string('imputed_run',512)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drg_receptions', function (Blueprint $table) {
            $table->string('imputed',255)->change();
            $table->string('imputed_run',255)->change();
        });
    }
}
