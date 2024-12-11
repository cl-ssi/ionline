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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->float('number', 4, 2);
            $table->text('name');
            $table->decimal('weighting_by_section', 6, 3)->nullable(); //ponderación por corte
            $table->string('evaluated_section_states')->nullable();
            $table->text('numerator');
            $table->text('numerator_source');
            $table->text('numerator_cods')->nullable();
            $table->text('numerator_cols')->nullable();
            $table->integer('numerator_acum_last_year')->nullable();
            $table->text('denominator')->nullable();
            $table->text('denominator_source')->nullable();
            $table->text('denominator_cods')->nullable();
            $table->text('denominator_cols')->nullable();
            $table->integer('denominator_acum_last_year')->nullable();
            $table->string('denominator_values_by_commune')->nullable();
            $table->foreignId('indicatorable_id')->constrained('ind_comges');
            $table->string('indicatorable_type');
            $table->string('goal')->nullable();
            $table->float('weighting', 6, 2)->nullable();
            $table->boolean('precision')->nullable();
            $table->string('level')->nullable();
            $table->string('population')->nullable();
            $table->string('professional')->nullable();
            $table->text('establishment_cods')->nullable();
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
        Schema::dropIfExists('indicators');
    }
};
