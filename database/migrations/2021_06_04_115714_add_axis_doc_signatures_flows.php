<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAxisDocSignaturesFlows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures_flows', function (Blueprint $table) {
            $table->integer('custom_y_axis')->after('observation')->nullable();
            $table->integer('custom_x_axis')->after('observation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_signatures_flows', function (Blueprint $table) {
            
            $table->dropColumn('custom_x_axis');
            $table->dropColumn('custom_y_axis');
        });
    }
}
