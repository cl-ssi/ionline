<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToWreControlItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_control_items', function (Blueprint $table) {
            $table->boolean('inventory')->after('correlative_po')->nullable(); // 1:inventariable 0:no-inventariable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wre_control_items', function (Blueprint $table) {
            //
        });
    }
}
