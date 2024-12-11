<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destiny_id')->constrained('frm_destines');
            $table->string('invoice')->nullable();
            $table->date('request_date');
            $table->date('due_date')->nullable();
            $table->string('patient_rut');
            $table->string('patient_name');
            $table->tinyInteger('age');
            $table->string('request_type');
            $table->foreignId('product_id')->constrained('frm_products');
            $table->integer('quantity');
            $table->string('diagnosis');
            $table->string('doctor_name');
            $table->string('remarks')->nullable();
            $table->foreignId('document_id')->nullable()->constrained('documents');

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
        Schema::dropIfExists('frm_deliveries');
    }
};
