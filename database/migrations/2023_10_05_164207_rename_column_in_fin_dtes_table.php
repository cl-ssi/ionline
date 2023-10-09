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
            $table->renameColumn('archivo_comprobante_pago_sigfe', 'comprobante_liquidacion_fondo');
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
            $table->renameColumn('comprobante_liquidacion_fondo', 'archivo_comprobante_pago_sigfe');
        });
    }
};
