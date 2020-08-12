<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrgReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drg_receptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parte')->nullable();
            $table->enum('parte_label', ['Parte','Oficio Reservado','RUC']);
            $table->unsignedInteger('parte_police_unit_id');
            $table->string('document_number');
            $table->unsignedInteger('document_police_unit_id');
            $table->date('document_date');
            $table->string('delivery')->nullable();
            $table->string('delivery_run')->nullable();
            $table->string('delivery_position')->nullable();
            $table->unsignedInteger('court_id');
            $table->string('imputed')->nullable();
            $table->string('imputed_run')->nullable();
            $table->text('observation')->nullable();
            $table->integer('reservado_isp_number')->nullable();
            $table->date('reservado_isp_date')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('lawyer_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parte_police_unit_id')->references('id')->on('drg_police_units');
            $table->foreign('document_police_unit_id')->references('id')->on('drg_police_units');
            $table->foreign('court_id')->references('id')->on('drg_courts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manager_id')->references('id')->on('users');
            $table->foreign('lawyer_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drg_receptions');
    }
}
