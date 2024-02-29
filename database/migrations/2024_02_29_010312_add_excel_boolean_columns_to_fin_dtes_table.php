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
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->boolean('excel_proveedor')->after('rejected_at')->nullable();
            $table->boolean('excel_cartera')->after('excel_proveedor')->nullable();
            $table->boolean('excel_requerimiento')->after('excel_cartera')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->dropColumn('excel_proveedor');
            $table->dropColumn('excel_cartera');
            $table->dropColumn('excel_requerimiento');
        });
    }
};
