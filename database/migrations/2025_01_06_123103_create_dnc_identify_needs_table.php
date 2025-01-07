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
            $table->string('status')->nullable();
            $table->string('subject')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->foreignId('estament_id')->nullable()->constrained('cfg_estaments');
            $table->string('family_position')->nullable();
            $table->string('nature_of_the_need')->nullable();
            $table->longText('question_1')->nullable();
            $table->longText('question_2')->nullable();
            $table->longText('question_3')->nullable();
            $table->longText('question_4')->nullable();
            $table->string('law')->nullable();
            $table->longText('question_5')->nullable();
            $table->longText('question_6')->nullable();
            $table->string('training_type')->nullable();
            $table->string('other_training_type')->nullable();
            $table->foreignId('strategic_axis_id')->nullable()->constrained('tng_strategic_axes');
            $table->foreignId('impact_objective_id')->nullable()->constrained('tng_impact_objectives');
            $table->string('mechanism')->nullable();
            $table->integer('places');

            // TIPO ONLINE
            $table->string('online_type_mechanism')->nullable();
            // TIPO PRESENCIAL
            $table->boolean('coffee_break')->nullable();
            $table->float('coffee_break_price', 15, 2)->nullable();
            // TIPO ASINCRONICO
            $table->boolean('exists')->nullable();
            $table->boolean('digital_capsule')->nullable();

            $table->boolean('transport')->nullable();
            $table->float('transport_price', 15, 2)->nullable();
            $table->boolean('accommodation')->nullable();
            $table->float('accommodation_price', 15, 2)->nullable();
            
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
