<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLowerAmountToArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->boolean('is_lower_amount')->nullable()->after('full_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->dropColumn('is_lower_amount');
        });
    }
}
