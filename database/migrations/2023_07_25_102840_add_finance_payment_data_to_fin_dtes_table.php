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
            $table->string('fin_status')->after('confirmation_observation')->nullable();
            $table->datetime('fin_payed_at')->after('fin_status')->nullable();
            $table->string('fin_folio_devengo')->after('fin_payed_at')->nullable();
            $table->string('fin_folio_tesoreria')->after('fin_folio_devengo')->nullable();
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
            $table->dropColumn('fin_status');
            $table->dropColumn('fin_payed_at');
            $table->dropColumn('fin_folio_devengo');
            $table->dropColumn('fin_folio_tesoreria');
        });
    }
};
