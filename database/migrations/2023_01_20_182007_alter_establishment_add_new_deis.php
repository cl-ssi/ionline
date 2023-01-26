<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterEstablishmentAddNewDeis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            //
            $table->string('deis')->change()->nullable();
            $table->integer('new_deis')->nullable()->after('deis');
        });
        DB::table('establishments')
        ->where('deis', 0)
        ->update(['deis' => null]);

        DB::update("update establishments set new_deis = replace(deis, '-', '') ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn('new_deis');
            $table->string('deis')->change();
        });

        DB::table('establishments')->where('deis', null)->update(['deis' => 0]);
    }
}
