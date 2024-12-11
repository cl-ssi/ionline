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
        Schema::create('jpp_job_position_profiles', function (Blueprint $table) {
            $table->id();

            //I.IDENTIFICACIÓN DEL CARGO
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->foreignId('user_creator_id')->nullable()->constrained('users');
            $table->foreignId('ou_creator_id')->nullable()->constrained('organizational_units');
            $table->foreignId('jpp_ou_id')->nullable()->constrained('organizational_units');
            $table->integer('charges_number')->nullable();
            $table->foreignId('estament_id')->nullable()->constrained('cfg_estaments');
            $table->foreignId('area_id')->nullable()->constrained('cfg_areas');
            $table->boolean('subordinates')->nullable();
            $table->foreignId('contractual_condition_id')->nullable()->constrained('cfg_contractual_conditions');
            $table->integer('degree')->nullable();
            $table->unsignedInteger('salary')->nullable();
            $table->string('law')->nullable();
            $table->boolean('dfl3')->nullable();
            $table->boolean('dfl29')->nullable();
            $table->boolean('other_legal_framework')->nullable();
            $table->string('working_day')->nullable();

            //II. REQUISITOS FORMALES
            $table->foreignId('staff_decree_by_estament_id')->nullable()->constrained('cfg_staff_decree_by_estaments');
            $table->longText('general_requirement')->nullable();
            $table->longText('specific_requirement')->nullable();
            $table->longText('training')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('technical_competence')->nullable();

            //III. PROPÓSITOS DEL CARGO
            $table->longText('objective')->nullable();

            //IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO
            $table->longText('working_team')->nullable();

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
        Schema::dropIfExists('jpp_job_position_profiles');
    }
};
