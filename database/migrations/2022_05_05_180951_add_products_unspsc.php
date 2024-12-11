<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents('database/unspsc/1-segments.sql'));
        DB::unprepared(file_get_contents('database/unspsc/2-families.sql'));
        DB::unprepared(file_get_contents('database/unspsc/3-classes.sql'));
        DB::unprepared(file_get_contents('database/unspsc/4-products.sql'));
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
};
