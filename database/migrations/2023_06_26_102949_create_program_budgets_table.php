<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cfg_program_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('cfg_programs');
            $table->integer('ammount');
            $table->date('period');
            $table->string('observation')->nullable();
            $table->foreignId('establishment_id')->constrained('establishments');
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
        Schema::dropIfExists('cfg_program_budgets');
    }
}
