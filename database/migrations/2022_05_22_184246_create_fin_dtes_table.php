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
        Schema::create('fin_dtes', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo');
            $table->string('tipo_documento');
            $table->string('folio')->nullable();
            $table->string('emisor')->nullable();
            $table->string('razon_social_emisor')->nullable();
            $table->string('receptor')->nullable();
            $table->datetime('publicacion')->nullable();
            $table->date('emision')->nullable();
            $table->string('monto_neto')->nullable();
            $table->string('monto_exento')->nullable();
            $table->string('monto_iva')->nullable();
            $table->string('monto_total')->nullable();
            $table->string('impuestos')->nullable();
            $table->string('estado_acepta')->nullable();
            $table->string('estado_sii')->nullable();
            $table->string('estado_intercambio')->nullable();
            $table->string('informacion_intercambio')->nullable();
            $table->string('uri')->nullable();

            $table->text('referencias')->nullable();
            $table->datetime('fecha_nar')->nullable();
            $table->string('estado_nar')->nullable();
            $table->string('uri_nar')->nullable();
            $table->string('mensaje_nar')->nullable();
            $table->string('uri_arm')->nullable();
            $table->datetime('fecha_arm')->nullable();
            $table->string('fmapago')->nullable();
            $table->text('controller')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('estado_cesion')->nullable();
            $table->string('url_correo_cesion')->nullable();
            $table->datetime('fecha_recepcion_sii')->nullable();
            $table->string('estado_reclamo')->nullable();
            $table->datetime('fecha_reclamo')->nullable();
            $table->string('mensaje_reclamo')->nullable();
            $table->string('estado_devengo')->nullable();
            $table->string('codigo_devengo')->nullable();
            $table->string('folio_oc')->nullable();
            $table->datetime('fecha_ingreso_oc')->nullable();
            $table->string('folio_rc')->nullable();
            $table->datetime('fecha_ingreso_rc')->nullable();
            $table->string('ticket_devengo')->nullable();
            $table->string('folio_sigfe')->nullable();
            $table->string('tarea_actual')->nullable();
            $table->string('area_transaccional')->nullable();
            $table->datetime('fecha_ingreso')->nullable();
            $table->datetime('fecha_aceptacion')->nullable();
            $table->datetime('fecha')->nullable();
            $table->foreignId('contract_manager_id')->nullable()->constrained('users');
            $table->boolean('confirmation_status')->nullable()->default(null);
            $table->foreignId('confirmation_sender_id')->nullable()->constrained('users');
            $table->datetime('confirmation_send_at')->nullable()->default(null);
            $table->boolean('all_receptions')->nullable()->default(false);
            $table->foreignId('all_receptions_user_id')->nullable()->constrained('users');
            $table->foreignId('all_receptions_ou_id')->nullable()->constrained('organizational_units');
            $table->datetime('all_receptions_at')->nullable();

            $table->string('confirmation_signature_file')->nullable();
            $table->boolean('payment_ready');
            $table->datetime('fin_payed_at')->nullable();
            $table->string('fin_folio_devengo')->nullable();
            $table->string('fin_folio_tesoreria')->nullable();
            $table->foreignId('sender_id')->nullable()->constrained('users');
            $table->foreignId('sender_ou')->nullable()->constrained('organizational_units');
            $table->datetime('sender_at')->nullable();
            $table->foreignId('payer_id')->nullable()->constrained('users');
            $table->foreignId('payer_ou')->nullable()->constrained('organizational_units');
            $table->datetime('payer_at')->nullable();
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');

            $table->string('cenabast_reception_file')->nullable();
            $table->string('cenabast_signed_pharmacist')->default(0);
            $table->string('cenabast_signed_boss')->default(0);
            $table->boolean('block_signature')->default(0);
            $table->string('folio_compromiso_sigfe')->nullable();
            $table->string('archivo_compromiso_sigfe')->nullable();
            $table->string('folio_devengo_sigfe')->nullable();
            $table->string('archivo_devengo_sigfe')->nullable();
            $table->string('comprobante_liquidacion_fondo')->nullable();
            $table->string('archivo_carga_manual')->nullable();
            $table->boolean('devuelto')->nullable();
            $table->boolean('rejected')->nullable();
            $table->text('reason_rejection')->nullable();
            $table->foreignId('rejected_user_id')->nullable()->constrained('users');
            $table->datetime('rejected_at')->nullable();
            $table->boolean('excel_proveedor')->nullable();
            $table->boolean('excel_cartera')->nullable();
            $table->boolean('excel_requerimiento')->nullable();
            $table->text('observation')->nullable();
            $table->boolean('paid')->nullable();
            $table->integer('paid_folio')->nullable();
            $table->date('paid_at')->nullable();
            $table->integer('paid_effective_amount')->nullable();
            $table->boolean('paid_automatic')->nullable();
            $table->boolean('paid_manual')->nullable();
            $table->boolean('check_tesoreria')->default(false);

            $table->timestamps();

            $table->index(['folio']);
            $table->index(['folio_oc']);
            $table->index(['emisor']);
            $table->index(['razon_social_emisor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_dtes');
    }
};
