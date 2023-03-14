<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLowerAmountToArqDirectDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_direct_deals', function (Blueprint $table) {
            $table->boolean('is_lower_amount')->nullable()->after('description');
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
            $table->dropColumn('is_lower_amount');
        });
    }
}
