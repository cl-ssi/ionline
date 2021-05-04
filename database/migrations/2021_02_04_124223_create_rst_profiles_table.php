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

            $table->date('degree_date');
            $table->string('file');
            $table->string('experience')->nullable();

            $table->foreignId('profile_manage_id');
            $table->foreignId('profession_manage_id')->nullable();
            $table->foreignId('replacement_staff_id');

            $table->foreign('profile_manage_id')->references('id')->on('rst_profile_manages');
            $table->foreign('profession_manage_id')->references('id')->on('rst_profession_manages');
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
