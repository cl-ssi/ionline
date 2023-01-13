<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEstablishmentIdToCfgPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_places', function (Blueprint $table) {
            $table->foreignId('establishment_id')
                ->nullable()
                ->after('location_id')
                ->constrained('establishments');
        });

        DB::update('update cfg_places set establishment_id = 38 where true');
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
