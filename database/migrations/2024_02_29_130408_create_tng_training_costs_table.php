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
        Schema::create('tng_training_costs', function (Blueprint $table) {
            $table->id();

            $table->string('type')->nullable();
            $table->string('other_type')->nullable();
            $table->boolean('exist')->nullable();
            $table->float('expense', 15, 2)->nullable();
            $table->foreignId('training_id')->nullable()->constrained('tng_trainings');

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
        Schema::dropIfExists('tng_training_costs');
    }
};
