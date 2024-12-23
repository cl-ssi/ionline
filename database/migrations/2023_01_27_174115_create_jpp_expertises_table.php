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
        Schema::create('jpp_expertises', function (Blueprint $table) {
            $table->id();

            $table->foreignId('estament_id')->nullable()->constrained('cfg_estaments');
            $table->foreignId('area_id')->nullable()->constrained('cfg_areas');
            $table->longText('name')->nullable();
            $table->longText('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('jpp_expertises_profile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('expertise_id')->nullable()->constrained('jpp_expertises');
            $table->string('value')->nullable();
            $table->foreignId('job_position_profile_id')->nullable()->constrained('jpp_job_position_profiles');

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
        Schema::dropIfExists('jpp_expertises');
        Schema::dropIfExists('jpp_expertise_profile');
    }
};
