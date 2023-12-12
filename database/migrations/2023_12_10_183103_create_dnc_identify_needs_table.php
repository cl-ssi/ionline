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
        Schema::create('dnc_identify_needs', function (Blueprint $table) {
            $table->id();

            $table->string('subject')->nullable();

            $table->longText('reason')->nullable();
            $table->longText('behaviors')->nullable();

            $table->boolean('performance_evaluation')->nullable();
            $table->boolean('observation_of_performance')->nullable();
            $table->boolean('report_from_other_users')->nullable();
            $table->boolean('organizational_unit_indicators')->nullable();
            $table->string('other')->nullable();

            $table->longText('goal')->nullable();
            $table->longText('expected_results')->nullable();
            $table->longText('longterm_impact')->nullable();
            $table->longText('immediate_results')->nullable();
            $table->longText('performance_goals')->nullable();

            /* OBJETIVOS DE APRENDIZAJE */

            $table->longText('current_training_level')->nullable();
            $table->longText('need_training_level')->nullable();
            $table->longText('expertise_required')->nullable();

            $table->longText('justification')->nullable();
            $table->longText('can_solve_the_need')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');

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
        Schema::dropIfExists('dnc_identify_needs');
    }
};
