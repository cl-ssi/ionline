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
        Schema::create('agr_process_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('bilateral')->default(false);
            $table->boolean('is_dependent')->default(false);
            // Aqui va father_process_type_id
            $table->boolean('has_resolution')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('agr_process_types', function (Blueprint $table) {
            $table->foreignId('father_process_type_id')->after('is_dependent')->nullable()->constrained('agr_process_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agr_process_types');
    }
};
