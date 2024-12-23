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
        Schema::create('drg_receptions', function (Blueprint $table) {
            $table->id('id');
            $table->timestamp('date')->nullable();
            $table->string('parte')->nullable();
            $table->enum('parte_label', ['Parte', 'Oficio Reservado', 'RUC']);
            $table->foreignId('parte_police_unit_id')->constrained('drg_police_units');
            $table->string('document_number');
            $table->foreignId('document_police_unit_id')->constrained('drg_police_units');
            $table->date('document_date');
            $table->string('delivery')->nullable();
            $table->string('delivery_run')->nullable();
            $table->string('delivery_position')->nullable();
            $table->foreignId('court_id')->constrained('drg_courts');
            $table->string('imputed', 512)->nullable();
            $table->string('imputed_run', 512)->nullable();
            $table->text('observation')->nullable();
            $table->integer('reservado_isp_number')->nullable();
            $table->date('reservado_isp_date')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignId('lawyer_id')->constrained('users');
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
        Schema::dropIfExists('drg_receptions');
    }
};
