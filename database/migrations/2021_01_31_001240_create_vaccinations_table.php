<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
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
            $table->foreignId('establishment_id');
            $table->foreignId('organizational_unit_id')->nullable();
            $table->string('organizationalUnit')->nullable();

            $table->datetime('first_dose')->nullable();
            $table->datetime('first_dose_at')->nullable();
            $table->string('fd_observation')->nullable();
            $table->datetime('second_doce')->nullable();
            $table->datetime('second_doce_at')->nullable();
            $table->string('sd_observation')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('establishment_id')->references('id')->on('establishments');
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
}
