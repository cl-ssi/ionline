<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('profession');
            $table->string('file');
            $table->string('file_name');

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
        Schema::dropIfExists('rst_profiles');
    }
}
