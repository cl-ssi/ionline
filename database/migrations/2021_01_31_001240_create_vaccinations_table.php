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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->integer('run');
            $table->char('dv');
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->string('email')->nullable();
            $table->string('personal_email')->nullable();
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('organizational_unit_id')->nullable();
            $table->string('organizationalUnit')->nullable();
            $table->boolean('inform_method')->nullable();

            $table->datetime('arrival_at')->nullable();
            $table->datetime('dome_at')->nullable();

            $table->datetime('first_dose')->nullable();
            $table->datetime('first_dose_arrival')->nullable();
            $table->datetime('first_dose_at')->nullable();
            $table->string('fd_observation')->nullable();

            $table->datetime('second_dose')->nullable();
            $table->datetime('second_dose_arrival')->nullable();
            $table->datetime('second_dose_at')->nullable();
            $table->string('sd_observation')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccinations');
    }
};
