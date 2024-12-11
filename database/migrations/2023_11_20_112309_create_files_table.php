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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('storage_path'); // Full path "ionline/reception/123.pdf"
            $table->boolean('stored')->default(false); // Si el archivo se subio o no

            $table->string('name')->nullable(); // "Acta de recepción.pdf"
            $table->string('type')->nullable(); // "Tipo opcional para los moduelos ej: documento, anexos, etc."

            $table->string('input_title')->nullable(); // "Titulo para mostrar en el input"
            $table->string('input_name')->nullable(); // "nombre del input" o wire:model="input_name
            $table->boolean('required')->default(false); // Si el archivo es requerido o no
            $table->string('valid_types')->nullable();  // opcional json_encode(["pdf", "xls"]),
            $table->integer('max_file_size')->nullable();  // opcional

            $table->foreignId('stored_by_id')->nullable()->constrained('users');

            // Parte de morph para las relaciones
            $table->string('fileable_type')->nullable();
            $table->unsignedBigInteger('fileable_id')->nullable();

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
        Schema::dropIfExists('files');
    }
};
