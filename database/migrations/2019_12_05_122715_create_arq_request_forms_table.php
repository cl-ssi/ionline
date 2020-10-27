<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_request_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estimated_expense')->nullable();//Gasto Estimado.
            $table->unsignedInteger('admin_id')->nullable();//id del adm. del contrato
            $table->string('program');//programa asociado.
            $table->longText('justification');//programa asociado.
            //$table->string('status')->nullable();//estado
            $table->string('type_form');//estado
            $table->unsignedInteger('previous_request_form_id')->nullable();//id de rf. anterior (padre).
            $table->string('bidding_number')->nullable();//id nro. de licitación.
            $table->unsignedInteger('whorequest_id')->unsigned()->nullable();//id del usuario.
            $table->unsignedInteger('whorequest_unit_id')->unsigned()->nullable();//id de su unidad organizacional.
            $table->string('whorequest_position')->nullable();
            $table->unsignedInteger('whoauthorize_id')->unsigned()->nullable();//id del usuario.
            $table->unsignedInteger('whoauthorize_unit_id')->unsigned()->nullable();//id de su unidad organizacional.
            $table->string('whoauthorize_position')->nullable();

            $table->unsignedInteger('finance_id')->unsigned()->nullable();//id del usuario.
            $table->unsignedInteger('finance_unit_id')->unsigned()->nullable();//id de su unidad organizacional.
            $table->string('finance_position')->nullable();
            $table->string('finance_program')->nullable();;//programa asociado.
            $table->string('folio_sigfe')->nullable();
            $table->string('folio_sigfe_id_oc')->nullable();
            $table->unsignedBigInteger('finance_expense')->nullable();//Gasto Estimado.
            $table->unsignedInteger('available_balance')->unsigned()->nullable();
            $table->unsignedInteger('program_balance')->unsigned()->nullable();

            $table->unsignedInteger('supplying_id')->unsigned()->nullable();//id del usuario.
            $table->unsignedInteger('supplying_unit_id')->unsigned()->nullable();//id de su unidad organizacional.
            $table->string('supplying_position')->nullable();
            $table->unsignedInteger('derive_supplying_id')->unsigned()->nullable();//id del usuario.
            $table->integer('oc_number')->nullable();
            $table->unsignedInteger('user_id')->unsigned();//id del usuario.

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
        Schema::dropIfExists('arq_request_forms');
    }
}
