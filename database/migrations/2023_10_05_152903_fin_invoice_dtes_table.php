<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Finance\Dte;

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
        $notInvoices = [
            'nota_credito',
            'guias_despacho',
            'nota_debito',
            'boleta_honorarios',
        ];

        /** Sólo las que no son factura */
        $dtes = Dte::whereNotNull('dte_id')->whereIn('tipo_documento',$notInvoices)->get();

        foreach($dtes as $dte) {
            $dte->invoices()->attach($dte->dte_id);
        }

        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->dropForeign(['dte_id']);
            $table->dropColumn('dte_id');
        });
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
