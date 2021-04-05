<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstRequestSingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_request_sings', function (Blueprint $table) {
            $table->id();

            // JEFATURA SOLICITANTE DEL CARGO
            $table->foreignId('leadership_organizational_unit_id');
            $table->foreignId('leadership_request_id')->nullable();
            $table->enum('leadership_request_status',['pending', 'accepted', 'rejected', 'observations']);
            $table->longText('leadership_observation')->nullable();
            $table->date('leadership_date_sing')->nullable();

            // SUBDIRECCIÓN DIRECTA
            $table->foreignId('sub_organizational_unit_id');
            $table->foreignId('sub_request_id')->nullable();
            $table->enum('sub_request_status',['pending', 'accepted', 'rejected', 'observations']);
            $table->longText('sub_observation')->nullable();
            $table->date('sub_date_sing')->nullable();

            // SUBDIRECCIÓN RRHH
            $table->foreignId('sub_rrhh_organizational_unit_id');
            $table->foreignId('sub_rrhh_request_id')->nullable();
            $table->enum('sub_rrhh_request_status',['pending', 'accepted', 'rejected', 'observations']);
            $table->longText('sub_rrhh_observation')->nullable();
            $table->date('sub_rrhh_date_sing')->nullable();

            $table->foreignId('request_replacement_staff_id');

            $table->foreign('leadership_organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('leadership_request_id')->references('id')->on('users');

            $table->foreign('sub_organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('sub_request_id')->references('id')->on('users');

            $table->foreign('sub_rrhh_organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('sub_rrhh_request_id')->references('id')->on('users');

            $table->foreign('request_replacement_staff_id')->references('id')->on('rst_request_replacement_staff');

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
        Schema::dropIfExists('rst_request_sings');
    }
}
