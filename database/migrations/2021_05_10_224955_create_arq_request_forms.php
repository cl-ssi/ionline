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
            $table->longText('name');
            $table->string('program')->nullable();
            $table->longText('justification');
            $table->tinyInteger('chief_approval');
            $table->string('type_form');
            $table->string('sigfe')->nullable();
            $table->string('bidding_number')->nullable();//id nro. de licitación.

            $table->enum('status', ['approved', 'rejected', 'created', 'in_progress', 'closed']);

            $table->bigInteger('purchase_mechanism_id')->unsigned();
            $table->bigInteger('purchase_unit_id')->unsigned()->nullable();
            $table->bigInteger('purchase_type_id')->unsigned()->nullable();


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('purchase_mechanism_id')->references('id')->on('cfg_purchase_mechanisms');
            $table->foreign('purchase_unit_id')->references('id')->on('cfg_purchase_units');
            $table->foreign('purchase_type_id')->references('id')->on('cfg_purchase_types');

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
