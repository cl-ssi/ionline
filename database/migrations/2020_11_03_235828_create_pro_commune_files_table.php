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
        Schema::create('pro_commune_files', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('description')->nullable();
            $table->json('access')->nullable();
            $table->string('file_a')->nullable();
            $table->string('file_b')->nullable();
            $table->string('file_c')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['active', 'inactive']);

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('commune_id')->constrained('communes');

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
};
