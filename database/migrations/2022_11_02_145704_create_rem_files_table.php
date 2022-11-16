<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rem_files', function (Blueprint $table) {
            $table->id();
            $table->date('period');
            // FIXME: corregir el tipo de dato de establishment para poder usar esta nomenclatura
            // $table->foreignId('establishment_id')->constrained('establishments');
            $table->unsignedInteger('establishment_id');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->string('filename')->nullable();
            $table->boolean('locked');

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
        Schema::dropIfExists('rem_files');
    }
}
