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
            $table->string('name'); // "Acta de recepción.pdf"
            $table->string('storage_path'); // "ionline/reception/123.pdf"
            
            $table->string('input_title')->nullable(); // "Titulo para mostrar en el input"
            $table->string('input_name')->nullable(); // "nombre del input"

            $table->string('type')->nullable();  // opcional
            $table->string('observation')->nullable(); // "Acta de recepción.pdf"

            // Parte de morph
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
