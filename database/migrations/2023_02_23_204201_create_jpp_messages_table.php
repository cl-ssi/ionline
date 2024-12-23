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
        Schema::create('jpp_messages', function (Blueprint $table) {
            $table->id();

            $table->integer('section')->nullable();
            $table->longText('message')->nullable();
            $table->foreignId('job_position_profile_id')->nullable()->constrained('jpp_job_position_profiles');
            $table->foreignId('user_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('jpp_messages');
    }
};
