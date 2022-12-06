<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProgrammingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_programmings', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('description')->nullable();

            $table->foreignId('user_id')->constrainde('users');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->json('access')->nullable();
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
        Schema::dropIfExists('pro_programmings');
    }
}
