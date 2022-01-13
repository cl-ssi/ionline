<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('request_user_id');
            $table->foreignId('request_user_ou_id');//u.o. del responsable
            $table->foreignId('contract_manager_id');
            $table->foreignId('contract_manager_ou_id');//u.o. del responsable
            $table->longText('name');
            $table->float('estimated_expense');
            $table->string('type_of_currency');
            $table->tinyInteger('superior_chief')->nullable();
            $table->string('program')->nullable();
            $table->longText('justification');
            $table->string('type_form');
            $table->string('subtype')->nullable();
            $table->string('sigfe')->nullable();
            $table->string('bidding_number')->nullable();//id nro. de licitación.

            $table->string('status');

            $table->bigInteger('purchase_mechanism_id')->unsigned();
            $table->bigInteger('purchase_unit_id')->unsigned()->nullable();
            $table->bigInteger('purchase_type_id')->unsigned()->nullable();

            $table->foreign('purchase_mechanism_id')->references('id')->on('cfg_purchase_mechanisms');
            $table->foreign('purchase_unit_id')->references('id')->on('cfg_purchase_units');
            $table->foreign('purchase_type_id')->references('id')->on('cfg_purchase_types');

            $table->foreign('request_user_id')->references('id')->on('users');
            $table->foreign('contract_manager_id')->references('id')->on('users');
            $table->foreign('request_user_ou_id')->references('id')->on('organizational_units');

            $table->foreignId('signatures_file_id')->nullable()->constrained('doc_signatures_files');

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
