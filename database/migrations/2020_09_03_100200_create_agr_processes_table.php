<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agr_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_type_id')->constrained('agr_process_types');
            $table->unsignedBigInteger('process_id')->nullable();
            $table->smallInteger('period');
            $table->foreignId('program_id')->constrained('cfg_programs')->nullable();
            $table->foreignId('commune_id')->constrained('cl_communes')->nullable();
            $table->foreignId('establishment_id')->constrained('establishments')->nullable();
            $table->smallInteger('quotas');
            $table->integer('total_amount')->nullable();
            $table->foreignId('signer_id')->constrained('agr_signers');
            $table->string('representative')->nullable();
            $table->string('representative_rut')->nullable();
            $table->string('representative_appelative')->nullable();
            $table->string('representative_decree')->nullable();
            $table->string('municipality_adress')->nullable();
            $table->string('municipality_rut')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->longText('establishment_list')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agr_processes');
    }
};
