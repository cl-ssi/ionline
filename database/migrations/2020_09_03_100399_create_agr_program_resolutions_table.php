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
        Schema::create('agr_program_resolutions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('number')->nullable();
            $table->string('file')->nullable();
            $table->foreignId('program_id')->constrained('agr_programs');
            $table->foreignId('referrer_id')->nullable()->constrained('users');
            $table->foreignId('director_signer_id')->nullable()->constrained('agr_signers');
            $table->integer('res_exempt_number')->nullable();
            $table->date('res_exempt_date')->nullable();
            $table->integer('res_resource_number')->nullable();
            $table->date('res_resource_date')->nullable();
            $table->string('establishment')->nullable();
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
        Schema::dropIfExists('agr_program_resolutions');
    }
};
