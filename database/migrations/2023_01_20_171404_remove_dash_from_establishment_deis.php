<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveDashFromEstablishmentDeis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            //
            Schema::table('establishments', function (Blueprint $table) {
                $table->string('deis')->nullable()->change();
                DB::statement("UPDATE establishments SET deis = REPLACE(deis, '-', '')");
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishment_deis', function (Blueprint $table) {
            //
            $table->string('deis')->change();
        });
    }
}
