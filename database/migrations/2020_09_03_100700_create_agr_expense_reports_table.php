<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrExpenseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_expense_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['Operación','Personal','Inversión','Otro']);
            $table->integer('expenditure_number');
            $table->date('expenditure_date');
            $table->integer('document_number')->nullable();
            $table->enum('document_type',['Factura','Boleta Honorarios','Otro']);
            $table->string('document_provider');
            $table->string('description');
            $table->enum('payment_type', ['Depósito', 'Transferencia bancaria', 'Cheque', 'Otro']);
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_expense_reports');
    }
}
