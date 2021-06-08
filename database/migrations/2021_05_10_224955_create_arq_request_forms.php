<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqRequestForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_request_forms', function (Blueprint $table) {
            $table->bigIncrements ('id');
            $table->foreignId('creator_user_id');
            $table->foreignId('applicant_user_id');//solicitante
            $table->foreignId('supervisor_user_id')->nullable();
            $table->foreignId('applicant_ou_id');//u.o. del responsable
            $table->string('applicant_position');
            $table->unsignedInteger('estimated_expense');
            $table->string('program')->nullable();
            $table->longText('justification');
            $table->string('type_form');
            $table->string('sigfe')->nullable();
            $table->string('bidding_number')->nullable();//id nro. de licitación.
            $table->string('purchase_mechanism');
            $table->enum('status', ['approved', 'rejected', 'created', 'in_progress', 'closed']);
            $table->enum('purchase_unit', ['BIENES Y SS', 'CGU', 'SSI', 'ADM DE FONDOS', 'OBRAS', 'FARMACOS',
                                           'ACTIVO FIJO', 'GORE',  'BIENESTAR'])->nullable();
            $table->enum('purchase_type', ['FONDO MENOR', 'OC INTERNA', 'FONDO A RENDIR', 'GRAN COMPRA', 'TRATO DIRECTO DE SUMINISTRO',
                                           'TRATO DIRECTO <1.000 UTM', 'TRATO DIRECTO < 4.999 UTM', 'TRATO DIRECTO > 5.000 UTM',
                                           'TRATO DIRECTO OBRAS', 'LICITACIÓN DE SUMINISTRO', 'L1', 'LE', 'LP', 'LQ', 'LR > 5.000 UTM',
                                           'LR > 8.000 UTM', 'LR > 15.000 UTM', 'ADDENDUM', 'RENOVACIÓN'])->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('applicant_user_id')->references('id')->on('users');
            $table->foreign('supervisor_user_id')->references('id')->on('users');
            $table->foreign('applicant_ou_id')->references('id')->on('organizational_units');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_request_forms');
    }
}
