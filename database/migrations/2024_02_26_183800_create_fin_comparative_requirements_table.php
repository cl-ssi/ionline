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
        Schema::create('fin_comparative_requirements', function (Blueprint $table) {
            $table->id();

            $table->string('dte_rut_emisor')->nullable();
            $table->integer('dte_folio')->nullable();
            $table->string('dte_razon_social_emisor')->nullable();
            $table->string('dte_tipo_documento')->nullable();

            $table->string('oc')->nullable();

            $table->integer('afectacion_folio')->nullable();
            $table->date('afectacion_fecha')->nullable();
            $table->string('afectacion_titulo')->nullable();
            $table->integer('afectacion_monto')->nullable();

            $table->integer('devengo_folio')->nullable();
            $table->date('devengo_fecha')->nullable();
            $table->string('devengo_titulo')->nullable();
            $table->integer('devengo_monto')->nullable();

            $table->integer('efectivo_folio')->nullable();
            $table->date('efectivo_fecha')->nullable();
            $table->integer('efectivo_monto')->nullable();

            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['dte_rut_emisor', 'dte_folio', 'dte_tipo_documento'], 'fin_comparative_requirements_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_comparative_requirements');
    }
};
