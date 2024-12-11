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
        Schema::table('establishments', function (Blueprint $table) {
            $table->foreignId('cl_commune_id')->nullable()->after('commune_id')->constrained('cl_communes');
        });
    }

    /**
     * 1.- Colchane = 1
     * 2.- Huara = 2
     * 3.- Camiña = 3
     * 4.- Pozo Almonte = 4
     * 5.- Pica = 5
     * 6.- Iquique = 6
     * 7.- Alto Hospicio = 7
     **/

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cl_commune_id');
        });
    }
};
