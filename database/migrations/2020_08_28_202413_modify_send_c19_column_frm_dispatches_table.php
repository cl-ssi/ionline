<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySendC19ColumnFrmDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->boolean('sendC19')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->boolean('sendC19')->change();
        });
    }
}
