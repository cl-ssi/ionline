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
        Schema::create('jpp_liabilities', function (Blueprint $table) {
            $table->id();

            $table->longText('name')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('jpp_profile_liabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('liability_id')->nullable()->constrained('jpp_liabilities');
            $table->boolean('value')->nullable();
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
        Schema::dropIfExists('jpp_liabilities');
        Schema::dropIfExists('jpp_profile_liabilities');
    }
};
