<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDateToDrgReceptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drg_receptions', function (Blueprint $table) {
            $table->timestamp('date')
                ->nullable()
                ->after('id');
        });

        DB::statement('UPDATE drg_receptions SET date = created_at WHERE true');
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
