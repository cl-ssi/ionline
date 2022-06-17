<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxToArqPurchasingProcessDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->string('tax')->nullable()->after('unit_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
    }
}
