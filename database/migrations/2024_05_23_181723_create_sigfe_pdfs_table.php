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
        Schema::create('sigfe_pdfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');
            $table->string('comprobante_pago_original')->nullable();
            $table->string('comprobante_pago_firmado')->nullable();
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
        Schema::dropIfExists('sigfe_pdfs');
    }
};
