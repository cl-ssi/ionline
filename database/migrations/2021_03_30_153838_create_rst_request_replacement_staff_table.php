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
            $table->enum('legal_quality',['to hire', 'fee']);
            $table->integer('salary')->nullable();
            $table->enum('fundament',['replacement',
                                      'quit',
                                      'allowance without payment',
                                      'regularization work position',
                                      'expand work position',
                                      'vacations',
                                      'other']);
            $table->string('name_to_replace')->nullable();
            $table->string('other_fundament')->nullable();
            $table->enum('work_day',['diurnal', 'third shift', 'fourth shift', 'other']);
            $table->string('other_work_day')->nullable();
            $table->integer('charges_number');
            $table->string('job_profile_file');

            $table->enum('request_status',['pending', 'complete', 'rejected']);

            $table->foreignId('user_id');
            $table->foreignId('organizational_unit_id');
            $table->foreignId('request_id')->nullable();

            $table->foreign('profile_manage_id')->references('id')->on('rst_profile_manages');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('request_id')->references('id')->on('rst_request_replacement_staff');

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
