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
        Schema::create('rst_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('replacement_staff_id')->constrained('rst_replacement_staff');
            $table->integer('psycholabor_evaluation_score')->nullable();
            $table->integer('technical_evaluation_score')->nullable();
            $table->longText('observations')->nullable();
            //Exclusive Selected
            $table->boolean('selected')->nullable();
            $table->boolean('desist')->nullable();
            $table->longText('desist_observation')->nullable();
            $table->string('reason')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('name_to_replace')->nullable();
            $table->string('replacement_reason')->nullable();
            $table->date('sirh_contract')->nullable();
            $table->foreignId('ou_of_performance_id')->nullable()->constrained('organizational_units');
            $table->foreignId('technical_evaluation_id')->constrained('rst_technical_evaluations');
            $table->foreignId('approval_id')->nullable()->constrained('sign_approvals');

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
        Schema::dropIfExists('rst_applicants');
    }
};
