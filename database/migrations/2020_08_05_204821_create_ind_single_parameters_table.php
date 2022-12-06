<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndSingleParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_single_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('law');
            $table->year('year');
            $table->decimal('indicator',10,2);
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->enum('type',['mensual','semestral','anual','acumulada']);
            $table->string('description')->nullable()->default(NULL);
            $table->integer('month')->nullable()->default(NULL);
            $table->enum('position',['numerador','denominador'])->default(NULL);
            $table->integer('value')->nullable()->default(NULL);
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
        Schema::dropIfExists('ind_single_parameters');
    }
}
