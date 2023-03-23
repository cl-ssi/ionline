<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstSelectedPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_selected_positions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('position_id')->constrained('rst_positions');

            $table->string('run')->nullable();
            $table->string('dv')->nullable();
            $table->string('name')->nullable();

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
        Schema::dropIfExists('rst_selected_positions');
    }
}
