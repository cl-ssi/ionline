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
        Schema::table('agr_budget_availability', function (Blueprint $table) {
            // // Eliminar la clave foránea existente
            $table->dropForeign(['program_id']);

            // drop index
            $table->dropIndex('agr_budget_availability_program_id_foreign');

            // // Renombrar la columna program_id a old_program_id
            $table->renameColumn('program_id', 'old_program_id');

            // Agregar la nueva columna program_id como clave foránea a cfg_programs
            $table->foreignId('program_id')->after('res_minsal_date')->nullable()->constrained('cfg_programs');
            $table->foreign('old_program_id')->references('id')->on('agr_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agr_budget_availability', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna program_id
            $table->dropForeign(['old_program_id']);
            $table->dropForeign(['program_id']);

            // drop index
            $table->dropIndex('agr_budget_availability_program_id_foreign');
            $table->dropIndex('agr_budget_availability_old_program_id_foreign');
            
            $table->dropColumn('program_id');


            // Renombrar la columna old_program_id a program_id
            $table->renameColumn('old_program_id', 'program_id');

            // Restaurar la clave foránea original
            $table->foreign('program_id')->references('id')->on('agr_programs');
        });
    }
};
