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
        Schema::create('rst_request_replacement_staff', function (Blueprint $table) {
            $table->id();
            $table->string('form_type')->nullable();
            $table->string('name');
            $table->foreignId('profile_manage_id')->nullable()->cosntrained('rst_profile_manages');
            $table->string('law')->nullable();
            $table->integer('degree')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            //LEGAL QUALITY
            $table->foreignId('legal_quality_manage_id')->nullable()->cosntrained('rst_legal_quality_manages');
            $table->integer('salary')->nullable();
            $table->foreignId('fundament_manage_id')->nullable()->cosntrained('rst_fundament_manages');
            $table->foreignId('fundament_detail_manage_id')->nullable()->cosntrained('rst_fundament_detail_manages');
            $table->string('name_to_replace')->nullable();
            $table->unsignedInteger('run')->nullable();
            $table->char('dv', 1)->nullable();
            $table->string('other_fundament')->nullable();
            $table->enum('work_day', ['diurnal', 'third shift', 'fourth shift', 'other']);
            $table->string('other_work_day')->nullable();
            $table->integer('charges_number')->nullable();
            $table->string('job_profile_file')->nullable();
            $table->string('request_verification_file');
            $table->foreignId('ou_of_performance_id')->constrained('organizational_units');
            $table->foreignId('replacement_staff_id')->nullable()->constrained('rst_replacement_staff');
            $table->string('request_status');
            $table->boolean('sirh_contract')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('requester_id')->nullable()->constrained('users');
            $table->foreignId('requester_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('request_id')->nullable()->constrained('rst_request_replacement_staff');
            $table->foreignId('budget_item_id')->nullable()->constrained('cfg_budget_items');
            $table->foreignId('signatures_file_id')->nullable()->constrained('doc_signatures_files');

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
};
