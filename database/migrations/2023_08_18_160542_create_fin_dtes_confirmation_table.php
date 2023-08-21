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
            $table->string('folio_oc')->nullable();
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');
            $table->boolean('cenabast')->nullable();
            $table->string('certificado_cumplimiento')->nullable();
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
