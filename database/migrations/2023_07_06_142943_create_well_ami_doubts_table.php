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
        Schema::create('well_ami_doubts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questioner_id')->nullable()->constrained('users');
            $table->datetime('question_at')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('rut')->nullable();
            $table->string('correo')->nullable();
            $table->string('establecimiento')->nullable();
            $table->string('motivo')->nullable();
            $table->text('consulta')->nullable();
            $table->text('respuesta')->nullable();
            $table->foreignId('answerer_id')->nullable()->constrained('users');
            $table->datetime('answer_at')->nullable();
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
        Schema::dropIfExists('well_ami_doubts');
    }
};
