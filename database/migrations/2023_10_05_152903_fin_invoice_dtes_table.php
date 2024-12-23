<?php

use App\Models\Finance\Dte;
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
        Schema::create('fin_invoice_dtes', function (Blueprint $table) {
            $table->id();
            // FIXME: tienen que ser nullables?
            $table->foreignId('invoice_id')->nullable()->constrained('fin_dtes');
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');
            $table->timestamps();
        });

        // 'factura_electronica',
        // 'factura_exenta',
        // 'guias_despacho',
        // 'nota_debito',
        // 'nota_credito',
        // 'boleta_honorarios',
        // 'boleta_electronica',
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_invoice_dtes');
    }
};
