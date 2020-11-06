<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProCommuneFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_commune_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->year('year');
            $table->string('description')->nullable();
            $table->json('access')->nullable();
            $table->string('file_a')->nullable();
            $table->string('file_b')->nullable();
            $table->string('file_c')->nullable();
            $table->text('observation')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('commune_id');

            $table->foreign('commune_id')->references('id')->on('communes');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('pro_commune_files');
    }
}
