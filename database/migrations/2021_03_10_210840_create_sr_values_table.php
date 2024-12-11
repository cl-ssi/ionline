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
        Schema::create('sr_values', function (Blueprint $table) {
            $table->id();
            $table->string('contract_type');
            $table->string('type');
            $table->string('work_type');
            $table->enum('estate', ['Médico 44', 'Médico 28', 'Médico 22', 'Profesional', 'Técnico', 'Administrativo', 'Farmaceutico', 'Odontólogo', 'Bioquímico', 'Auxiliar', 'Otro (justificar)'])->nullable();
            $table->float('amount', 8, 2);
            $table->date('validity_from');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
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
        Schema::dropIfExists('sr_values');
    }
};
