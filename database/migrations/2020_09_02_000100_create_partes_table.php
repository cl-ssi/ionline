<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partes', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->datetime('entered_at');
            $table->enum('type', ['Carta','Circular','Decreto', 'Demanda', 'Informe', 'Memo', 'Oficio', 'Ordinario', 'Otro', 'Permiso Gremial', 'Reservado', 'Resolución']);
            $table->date('date');
            $table->integer('number')->unsigned()->nullable();
            //$table->unsignedInteger('organizational_unit_id')->nullable();
            $table->string('origin')->nullable();
            $table->text('subject');
            $table->boolean('important')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //$table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partes');
    }
}
