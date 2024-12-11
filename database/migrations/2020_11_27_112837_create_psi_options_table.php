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
        Schema::create('psi_options', function (Blueprint $table) {
            $table->id();
            $table->longText('option_text');
            $table->char('alternative', 1);
            $table->integer('points')->nullable();
            $table->foreignId('question_id')->constrained('psi_questions');
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
        Schema::dropIfExists('psi_options');
    }
};
