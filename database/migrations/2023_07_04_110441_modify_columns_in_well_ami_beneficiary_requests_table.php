<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInWellAmiBeneficiaryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('well_ami_beneficiary_requests', function (Blueprint $table) {
            //
            $table->string('fecha_inicio_contrato')->change();
            $table->string('fecha_termino_contrato')->change();
            $table->string('fecha_nacimiento')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('well_ami_beneficiary_requests', function (Blueprint $table) {
            //
            $table->date('fecha_inicio_contrato')->change();
            $table->date('fecha_termino_contrato')->change();
            $table->date('fecha_nacimiento')->change();
        });
    }
}
