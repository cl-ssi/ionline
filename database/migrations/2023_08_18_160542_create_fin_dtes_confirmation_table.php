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
        Schema::create('fin_dtes_confirmation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');
            $table->string('folio_oc')->nullable();
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->boolean('cenabast')->nullable();
            $table->string('certificado_cumplimiento')->nullable(); //averiguar si es cumplimiento o conformidad
            $table->string('acta_ingreso')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_dtes_confirmation');
    }
};
