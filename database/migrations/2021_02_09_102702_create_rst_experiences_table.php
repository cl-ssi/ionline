<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_experiences', function (Blueprint $table) {
            $table->id();

            $table->longText('previous_experience');
            $table->longText('performed_functions');
            $table->string('file');
            $table->string('contact_name')->nullable();
            $table->string('contact_telephone')->nullable();

            $table->foreignId('replacement_staff_id');

            $table->foreign('replacement_staff_id')->references('id')->on('rst_replacement_staff');

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
        Schema::dropIfExists('rst_experiences');
    }
}
