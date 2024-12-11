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
        Schema::create('rem_files', function (Blueprint $table) {
            $table->id();
            $table->date('period');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->string('filename')->nullable();
            $table->boolean('locked');

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
};
