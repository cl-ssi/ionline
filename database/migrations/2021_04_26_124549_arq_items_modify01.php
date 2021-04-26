<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArqItemsModify01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('arq_items', function (Blueprint $table) {
            $table->renameColumn('item', 'article');
            $table->float('unit_value', 8, 2);
            $table->string('unit_of_measurement');
            $table->string('tax');
        });
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
