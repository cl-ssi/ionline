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
        Schema::create('fin_tgr_payed_dtes', function (Blueprint $table) {
            $table->id();
            $table->string('rut_emisor')->nullable();
            $table->string('folio_documento')->nullable();
            $table->string('razon_social_emisor')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('area_transaccional')->nullable();
            $table->string('folio')->nullable();
            $table->string('tipo_operacion')->nullable();
            $table->string('fecha_generacion')->nullable();
            $table->string('cuenta_contable')->nullable();
            $table->string('tipo_documento_tgr')->nullable();
            $table->string('nro_documento')->nullable();
            $table->string('fecha_cumplimiento')->nullable();
            $table->string('combinacion_catalogo')->nullable();
            $table->string('principal')->nullable();
            $table->string('principal_relacionado')->nullable();
            $table->string('beneficiario')->nullable();
            $table->string('banco_cta_corriente')->nullable();
            $table->string('medio_pago')->nullable();
            $table->string('tipo_medio_pago')->nullable();
            $table->string('nro_documento_pago')->nullable();
            $table->string('fecha_emision')->nullable();
            $table->string('estado_documento')->nullable();
            $table->string('monto')->nullable();
            $table->string('moneda')->nullable();
            $table->string('tipo_cambio')->nullable();
            $table->string('banco_beneficiario')->nullable();
            $table->string('cuenta_beneficiaria')->nullable();
            $table->string('medio_de_pago')->nullable();
            $table->string('numero_de_medio_de_pago')->nullable();
            $table->string('cuenta_tgr')->nullable();
            $table->foreignId('document_id')->nullable()->constrained('documents');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['rut_emisor', 'folio_documento']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_tgr_payed_dtes');
    }
};
