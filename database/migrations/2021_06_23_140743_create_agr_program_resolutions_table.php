<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgrProgramResolutionsTable extends Migration
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
            $table->foreignId('program_id');
            $table->foreign('program_id')->references('id')->on('agr_programs');
            $table->foreignId('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->foreignId('director_signer_id')->nullable();
            $table->foreign('director_signer_id')->references('id')->on('agr_signers');
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
}
