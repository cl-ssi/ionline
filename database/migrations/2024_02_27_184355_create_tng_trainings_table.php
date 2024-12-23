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
        Schema::create('tng_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            //$table->foreignId('user_training_id')->nullable()->constrained('users');
            $table->unsignedBigInteger('user_training_id')->nullable();
            $table->string('user_training_type')->nullable();
            $table->foreignId('estament_id')->nullable()->constrained('cfg_estaments');
            $table->string('law')->nullable();
            $table->string('degree')->nullable();
            $table->string('work_hours')->nullable();
            $table->foreignId('contractual_condition_id')->nullable()->constrained('cfg_contractual_conditions');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->foreignId('strategic_axes_id')->nullable()->constrained('tng_strategic_axes');
            $table->text('objective')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('activity_type')->nullable();
            $table->string('other_activity_type')->nullable();
            $table->string('activity_in')->nullable();
            $table->foreignId('commune_id')->nullable()->constrained('cl_communes');
            $table->boolean('allowance')->nullable();
            $table->string('mechanism')->nullable();
            $table->string('online_type')->nullable();
            $table->string('schuduled')->nullable();
            $table->date('activity_date_start_at')->nullable();
            $table->date('activity_date_end_at')->nullable();
            $table->decimal('total_hours', 4, 1)->nullable();
            $table->date('permission_date_start_at')->nullable();
            $table->date('permission_date_end_at')->nullable();
            $table->string('place')->nullable();
            $table->string('working_day')->nullable();
            $table->text('technical_reasons')->nullable();
            $table->string('feedback_type')->nullable();
            $table->string('municipal_profile')->nullable();
            $table->foreignId('user_creator_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('tng_trainings');
    }
};
