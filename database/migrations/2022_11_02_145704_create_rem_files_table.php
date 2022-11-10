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
            $table->string('filename');
            $table->unsignedInteger('year');
            $table->unsignedInteger('month');
            /* FIXME: Usa esta nomenclatura $table->foreignId('ou_id')->constrained('organizational_units'); */
            $table->unsignedInteger('establishment_id');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->boolean('is_locked');
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
