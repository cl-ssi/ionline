<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJppJobPositionProfileSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jpp_job_position_profile_signs', function (Blueprint $table) {
            $table->id();

            $table->integer('position');
            $table->string('event_type');
            $table->foreignId('organizational_unit_id');
            $table->foreignId('user_id')->nullable();
            $table->string('status')->nullable();
            $table->longText('observation')->nullable();
            $table->dateTime('date_sign')->nullable();
            $table->foreignId('job_position_profile_id');

            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('job_position_profile_id')->references('id')->on('jpp_job_position_profiles');

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
        Schema::dropIfExists('jpp_job_position_profile_signs');
    }
}
