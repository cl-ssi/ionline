<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrAccountabilityDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_accountability_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Operacional','Personal','Inversión']);
            $table->string('egressNumber');
            $table->date('egressDate');
            $table->string('docNumber');
            $table->enum('docType',['Boleta','Boleta Honorario','Factura','Liquidación']);
            $table->string('docProvider');
            $table->text('description');
            $table->enum('paymentType',['Efectivo','Cheque','Transferencia']);
            $table->integer('amount');
            $table->unsignedBigInteger('accountability_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('accountability_id')->references('id')->on('agr_accountabilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_accountability_details');
    }
}
