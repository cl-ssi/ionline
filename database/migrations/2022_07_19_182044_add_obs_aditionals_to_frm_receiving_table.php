<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObsAditionalsToFrmReceivingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frm_receivings', function (Blueprint $table) {
            // $table->text('observation')->after('notes')->nullable();
            $table->text('order_number')->after('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_receivings', function (Blueprint $table) {
            // $table->dropColumn(['observation']);
            $table->dropColumn(['order_number']);
        });
    }
}
