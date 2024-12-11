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
        Schema::create('prof_agenda_proposal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('prof_agenda_proposals');
            $table->foreignId('activity_type_id')->constrained('prof_agenda_activity_types');
            $table->integer('day');
            $table->string('start_hour');
            $table->string('end_hour');
            $table->integer('duration');

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
        Schema::dropIfExists('prof_agenda_proposal_details');
    }
};
