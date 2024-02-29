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
        Schema::create('fin_tgr_accounting_portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('rut_emisor')->nullable();
            $table->integer('folio_documento')->nullable();
            $table->string('razon_social_emisor')->nullable();
            $table->string('cuenta_contable')->nullable();
            $table->string('principal')->nullable();
            $table->integer('saldo')->nullable();
            $table->string('tipo_movimiento')->nullable();
            $table->date('fecha')->nullable();
            $table->string('titulo')->nullable();
            $table->integer('debe')->nullable();
            $table->integer('haber')->nullable();
            $table->integer('saldo_acumulado')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->integer('numero')->nullable();
            $table->string('origen_transaccion')->nullable();
            $table->integer('numero_documento')->nullable();
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['rut_emisor', 'folio_documento', 'tipo_documento'], 'fin_tgr_accounting_portfolios_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_tgr_accounting_portfolios');
    }
};
