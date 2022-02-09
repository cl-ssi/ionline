<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolDirectDealToArqDirectDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_direct_deals', function (Blueprint $table) {
            $table->string('resol_direct_deal')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_direct_deals', function (Blueprint $table) {
            $table->dropColumn('resol_direct_deal');
        });
    }
}
