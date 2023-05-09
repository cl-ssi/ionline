<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinDtesTable extends Migration
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
            $table->timestamps();
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
}
