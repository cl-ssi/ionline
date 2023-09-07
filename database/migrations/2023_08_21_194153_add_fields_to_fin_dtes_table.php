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
            $table->string('folio_compromiso_sigfe')->nullable()->after('cenabast');
            $table->string('archivo_compromiso_sigfe')->nullable()->after('folio_compromiso_sigfe');
            $table->string('folio_devengo_sigfe')->nullable()->after('archivo_compromiso_sigfe');
            $table->string('archivo_devengo_sigfe')->nullable()->after('folio_devengo_sigfe');
            $table->boolean('devuelto')->nullable()->after('archivo_devengo_sigfe');
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
            $table->dropColumn('folio_compromiso_sigfe');
            $table->dropColumn('archivo_compromiso_sigfe');
            $table->dropColumn('folio_devengo_sigfe');
            $table->dropColumn('archivo_devengo_sigfe');
            $table->dropColumn('devuelto');
        });
    }
};
