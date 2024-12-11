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
        Schema::create('complaint_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('complaint_principles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Consulta', 'Denuncia', 'Riesgo ético']);
            $table->foreignId('complaint_values_id')->constrained('complaint_values');
            $table->string('other_value')->nullable();
            $table->foreignId('complaint_principles_id')->constrained('complaint_principles');
            $table->longtext('content');
            $table->string('file')->nullable();
            $table->string('email');
            $table->boolean('know_code');
            $table->boolean('identify');
            // $table->unsignedBigInteger('user_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('complaint_values');
        Schema::dropIfExists('complaint_principles');
    }
};
