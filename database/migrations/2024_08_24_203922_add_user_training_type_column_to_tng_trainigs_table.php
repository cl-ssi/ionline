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
        Schema::table('tng_trainings', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea
            $table->dropForeign(['user_training_id']);
            
            // Convertir el campo 'user_training_id' en una columna estándar
            $table->unsignedBigInteger('user_training_id')->nullable()->change();
            
            // Agregar la nueva columna para la relación polimórfica
            $table->string('user_training_type')->after('user_training_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tng_trainings', function (Blueprint $table) {
            // Volver a agregar la relación con la tabla 'users' en el método down
            $table->dropColumn('user_training_type');
            $table->foreignId('user_training_id')->nullable()->constrained('users')->change();
        });
    }
};
