<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProActivityItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_activity_items', function (Blueprint $table) {
            $table->id();
            $table->string('int_code')->nullable();
            $table->string('vital_cycle')->nullable();
            $table->enum('tracer',['SI','NO'])->nullable()->default('NO');
            $table->string('action_type')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('def_target_population')->nullable();
            $table->string('verification_rem')->nullable();
            $table->string('professional')->nullable();

            $table->bigInteger('activity_id')->unsigned();
 
            $table->foreign('activity_id')->references('id')->on('pro_activity_programs');

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
        Schema::dropIfExists('pro_activity_items');
    }
}
