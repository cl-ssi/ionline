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
        Schema::create('parte_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parte_id')->constrained('partes');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('action', ['Ingresado', 'Recepcionado', 'Derivado', 'Respondido', 'Archivado', 'Anulado', 'Comentado']);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->string('file')->nullable();
            // $table->boolean('active')->nullable();
            // $table->unsignedBigInteger('parte_events_id')->nullable();
            //$table->foreign('parte_events_id')->references('id')->on('parte_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parte_events');
    }
};
