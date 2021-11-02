<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodsColsToProActivityItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_activity_items', function (Blueprint $table) {
            $table->text('cods')->nullable()->after('professional');
            $table->text('cols')->nullable()->after('cods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_activity_items', function (Blueprint $table) {
            //
        });
    }
}
