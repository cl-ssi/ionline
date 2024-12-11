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
        Schema::create('rst_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_manage_id')->constrained('rst_profile_manages');
            $table->string('law')->nullable();
            $table->integer('degree')->nullable();
            //LEGAL QUALITY
            $table->foreignId('legal_quality_manage_id')->constrained('rst_legal_quality_manages');
            $table->integer('salary')->nullable();
            $table->foreignId('fundament_manage_id')->constrained('rst_fundament_manages');
            $table->foreignId('fundament_detail_manage_id')->nullable()->constrained('rst_fundament_detail_manages');
            $table->string('other_fundament')->nullable();
            $table->string('work_day');
            $table->string('other_work_day')->nullable();
            $table->integer('charges_number');
            $table->string('job_profile_file');
            $table->foreignId('request_replacement_staff_id')->constrained('rst_request_replacement_staff');

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
        Schema::dropIfExists('rst_positions');
    }
};
