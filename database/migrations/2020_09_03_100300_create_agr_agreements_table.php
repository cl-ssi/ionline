<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->smallInteger('period');
            $table->string('file')->nullable();
            $table->string('fileAgreeEnd')->nullable();
            $table->string('fileResEnd')->nullable();
            $table->unsignedBigInteger('program_id');
            $table->unsignedInteger('commune_id');
            $table->smallInteger('quotas');
            $table->string('referente');
            
            // MUNICIPALIDAD
            $table->string('representative')->nullable();
            $table->string('representative_rut')->nullable();
            $table->string('municipality_adress')->nullable();
            $table->string('municipality_rut')->nullable();

            // RESOLUCIÓN
            $table->integer('number')->nullable();// NÚMERO RESOLUCIÓN DEL CONVENIO
            $table->date('resolution_date')->nullable();

            // RESOLUCIÓN EXCENTA
            $table->integer('res_exempt_number')->nullable();// NÚMERO RESOLUCIÓN EXCENTA
            $table->date('res_exempt_date')->nullable();

            // RESOLUCIÓN DISTRIBUYE RECURSOS
            $table->integer('res_resource_number')->nullable();// NÚMERO RESOLUCIÓN DISTRIBUYE RECURSOS
            $table->date('res_resource_date')->nullable();

            // CONVENIOS ESTABLECIMIENTOS
            $table->json('establishment_list')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_id')->references('id')->on('agr_programs');
            $table->foreign('commune_id')->references('id')->on('communes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_agreements');
    }
}
