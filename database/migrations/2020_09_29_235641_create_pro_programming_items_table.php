<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProgrammingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_programming_items', function (Blueprint $table) {
            $table->id();
            $table->string('cycle')->nullable();
            $table->string('action_type')->nullable();
            $table->string('ministerial_program')->nullable();
            $table->integer('activity_id')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('def_target_population')->nullable();
            $table->string('source_population')->nullable();
            $table->integer('cant_target_population')->nullable();
            $table->decimal('prevalence_rate',5,1)->nullable();
            $table->string('source_prevalence')->nullable();
            $table->decimal('coverture',5,1)->nullable();
            $table->integer('population_attend')->nullable(); // Población a atender
            $table->integer('concentration')->nullable(); // Cantidad de veces que debo darle control anual
            $table->integer('activity_total')->nullable();

            $table->integer('activity_group')->nullable();
            $table->integer('workshop_number')->nullable();
            $table->integer('workshop_session_number')->nullable();
            $table->decimal('workshop_session_time',5,2)->nullable();

            $table->string('professional')->nullable();
            $table->decimal('activity_performance',5,1)->nullable();
            $table->double('hours_required_year',5,2)->nullable();
            $table->double('hours_required_day',5,2)->nullable();
            $table->double('direct_work_year',5,2)->nullable(); // Jornadas Directas Año
            $table->double('direct_work_hour',15,8)->nullable(); // Jornadas Horas Directas Diarias double('column', 15, 8)
            $table->string('information_source')->nullable();
            $table->string('prap_financed')->nullable();
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->bigInteger('programming_id')->unsigned();
 
            $table->foreign('programming_id')->references('id')->on('pro_programmings');
            $table->foreign('user_id')->references('id')->on('users');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_programming_items');
    }
}
