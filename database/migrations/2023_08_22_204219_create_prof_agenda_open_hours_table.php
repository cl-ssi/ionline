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
            $table->foreignId('proposal_detail_id')->constrained('prof_agenda_proposal_details');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->foreignId('patient_id')->nullable()->constrained('users');
            $table->string('observation')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('blocked')->default(0);
            $table->string('deleted_bloqued_observation')->nullable();

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
