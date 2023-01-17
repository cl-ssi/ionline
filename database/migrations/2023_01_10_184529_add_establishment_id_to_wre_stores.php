<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEstablishmentIdToWreStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_stores', function (Blueprint $table) {
            $table->foreignId('establishment_id')
                ->nullable()
                ->after('commune_id')
                ->constrained('establishments');
        });

        DB::update('update wre_stores set establishment_id = 38 where true');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
