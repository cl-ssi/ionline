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
        Schema::create('prof_agenda_open_hours', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('proposal_detail_id')->constrained('prof_agenda_proposal_details');
            $table->unsignedBigInteger('proposal_detail_id')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->foreignId('patient_id')->nullable()->constrained('users');
            $table->foreignId('external_user_id')->nullable()->constrained('prof_agenda_external_users');
            $table->string('observation')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('blocked')->default(0);
            $table->string('deleted_bloqued_observation')->nullable();
            $table->boolean('assistance')->nullable();
            $table->string('absence_reason')->nullable();
            $table->foreignId('profesional_id')->nullable()->constrained('users');
            $table->foreignId('profession_id')->nullable()->constrained('cfg_professions');
            $table->foreignId('activity_type_id')->nullable()->constrained('prof_agenda_activity_types');
            $table->foreignId('reserver_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('prof_agenda_open_hours');
    }
};
