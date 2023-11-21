<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fin_purchase_orders', function (Blueprint $table) {
            $table->boolean('cenabast')->after('data')->nullable();
            $table->boolean('completed')->after('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('cenabast');
            $table->dropColumn('completed');
        });
    }
};
