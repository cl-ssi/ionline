<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstRequestReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_request_replacement_staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('profile_manage_id');
            $table->integer('degree')->nullable();
            $table->date('start_date');
            $table->date('end_date');

            //LEGAL QUALITY
            $table->foreignId('legal_quality_manage_id');
            $table->foreign('legal_quality_manage_id')->references('id')->on('rst_legal_quality_manages');
            $table->integer('salary')->nullable();
            $table->foreignId('fundament_manage_id');
            $table->foreign('fundament_manage_id')->references('id')->on('rst_fundament_manages');
            $table->foreignId('fundament_detail_manage_id');
            $table->foreign('fundament_detail_manage_id')->references('id')->on('rst_fundament_detail_manages');
            $table->string('name_to_replace')->nullable();
            $table->string('other_fundament')->nullable();

            $table->enum('work_day',['diurnal', 'third shift', 'fourth shift', 'other']);
            $table->string('other_work_day')->nullable();
            $table->integer('charges_number');
            $table->string('job_profile_file')->nullable();
            $table->string('request_verification_file');
            $table->foreignId('ou_of_performance_id');

            $table->enum('request_status',['pending', 'complete', 'rejected']);

            $table->foreignId('user_id');
            $table->foreignId('organizational_unit_id');
            $table->foreignId('request_id')->nullable();

            $table->foreign('profile_manage_id')->references('id')->on('rst_profile_manages');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('request_id')->references('id')->on('rst_request_replacement_staff');
            $table->foreign('ou_of_performance_id')->references('id')->on('organizational_units');

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
        Schema::dropIfExists('rst_request_replacement_staff');
    }
}
