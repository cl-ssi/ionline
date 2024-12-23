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
        Schema::create('prof_agenda_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100); // nuevo horario, reprogramación
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('profession_id')->constrained('cfg_professions');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('status'); // creado, pendiente, cerrado, aperturado
            $table->longText('observation')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('mp_programming_proposals_detail', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('programming_proposal_id');
        //     $table->unsignedInteger('activity_id');
        //     $table->unsignedBigInteger('sub_activity_id')->nullable();
        //     $table->integer('day');
        //     $table->string('start_hour');
        //     $table->string('end_hour');

        //     $table->foreign('programming_proposal_id','mp_prog_prop_det_prog_prop_id_foreign')->references('id')->on('mp_programming_proposals');
        //     $table->foreign('activity_id')->references('id')->on('mp_activities');
        //     $table->foreign('sub_activity_id')->references('id')->on('mp_sub_activities');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('prof_agenda_proposal_details', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('programming_proposal_id')->constrained('prof_agenda_proposals');
        //     $table->string('type', 100); //funcionario, jefe de servicio, subdirección médica
        //     $table->integer('sign_position');
        //     $table->datetime('signature_date');
        //     $table->string('status')->nullable();
        //     $table->longText('observation')->nullable();

        //     $table->foreign('programming_proposal_id')->references('id')->on('mp_programming_proposals');
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('mp_programming_proposals_detail');
        // Schema::dropIfExists('mp_programming_proposals_signature_flow');
        Schema::dropIfExists('prof_agenda_proposals');
    }
};
