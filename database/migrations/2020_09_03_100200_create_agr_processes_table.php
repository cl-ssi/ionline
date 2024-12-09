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
            $table->foreignId('program_id')->constrained('cfg_programs')->nullable();
            $table->smallInteger('period');
            $table->foreignId('process_type_id')->constrained('agr_process_types');

            $table->foreignId('commune_id')->constrained('cl_communes')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->longText('establishments')->nullable();

            // $table->foreignId('establishment_id')->constrained('establishments')->nullable();
            $table->unsignedSmallInteger('quotas_qty')->nullable();

            $table->foreignId('signer_id')->constrained('agr_signers');
            $table->string('signer_appellative'); // APELATIVO DIRECTOR, DIRECTOR (S)
            $table->text('signer_decree'); // DECRETO DIRECTOR
            $table->string('signer_name')->constrained('users'); // DIRECTOR NAME

            $table->foreignId('municipality_id')->constrained('cfg_municipalities');
            $table->string('municipality_name')->nullable();
            $table->string('municipality_rut')->nullable();
            $table->string('municipality_adress')->nullable();

            $table->foreignId('mayor_id')->constrained('cfg_mayors');
            $table->string('mayor_name')->nullable();
            $table->string('mayor_run')->nullable();
            $table->string('mayor_appelative')->nullable();
            $table->string('mayor_decree')->nullable();

            $table->enum('status', ['draft', 'approved', 'rejected', 'finished'])->default('draft');

            $table->foreignId('document_id')->nullable()->constrained('documents');
            $table->text('document_content')->nullable();

            $table->foreignId('next_process_id')->nullable()->constrained('agr_processes')->nullOnDelete();

            $table->foreignId('establishment_id')->constrained('establishments');

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
