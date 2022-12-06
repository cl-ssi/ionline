<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlwAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alw_allowances', function (Blueprint $table) {
            $table->id();

            $table->string('status')->nullable();
            $table->foreignId('user_allowance_id');
            $table->string('contractual_condition')->nullable();
            $table->foreignId('allowance_value_id');
            $table->unsignedBigInteger('establishment_id');
            $table->foreignId('organizational_unit_allowance_id');
            $table->string('place')->nullable();
            $table->string('reason')->nullable();
            $table->boolean('overnight')->nullable();
            $table->boolean('passage')->nullable();
            $table->string('means_of_transport')->nullable();
            $table->foreignId('origin_commune_id');
            $table->foreignId('destination_commune_id');
            $table->string('round_trip')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->boolean('from_half_day')->nullable();
            $table->boolean('to_half_day')->nullable();
            $table->foreignId('creator_user_id');
            $table->foreignId('creator_ou_id');
            $table->date('document_date')->nullable();
            $table->foreignId('signatures_file_id')->nullable();

            $table->foreign('user_allowance_id')->references('id')->on('users');
            $table->foreign('allowance_value_id')->references('id')->on('cfg_allowance_values');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('organizational_unit_allowance_id')->references('id')->on('organizational_units');
            $table->foreign('origin_commune_id')->references('id')->on('cl_communes');
            $table->foreign('destination_commune_id')->references('id')->on('cl_communes');
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('creator_ou_id')->references('id')->on('organizational_units');
            $table->foreign('signatures_file_id')->references('id')->on('doc_signatures_files');

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
        Schema::dropIfExists('alw_allowances');
    }
}