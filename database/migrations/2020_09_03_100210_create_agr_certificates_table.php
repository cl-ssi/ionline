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
        Schema::create('agr_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_type_id')->constrained('agr_process_types');
            $table->smallInteger('period');
            $table->foreignId('program_id')->constrained('cfg_programs');
            $table->foreignId('commune_id')->nullable()->constrained('cl_communes');

            $table->integer('number')->nullable();
            $table->date('date')->nullable();

            $table->enum('status', ['draft', 'approved', 'rejected', 'finished'])->default('draft');

            $table->text('document_content')->nullable();

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
        Schema::dropIfExists('agr_certificates');
    }
};
