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
        Schema::create('pro_activity_items', function (Blueprint $table) {
            $table->id();
            $table->string('int_code')->nullable();
            $table->string('vital_cycle')->nullable();
            $table->enum('tracer', ['SI', 'NO'])->nullable()->default('NO');
            $table->string('action_type')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('def_target_population')->nullable();
            $table->string('verification_rem')->nullable();
            $table->string('professional')->nullable();
            $table->text('cods')->nullable();
            $table->text('cols')->nullable();

            $table->foreignId('activity_id')->constrained('pro_activity_programs');
            $table->foreignId('activity_item_id')->nullable()->constrained('pro_activity_items');

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
        Schema::dropIfExists('pro_activity_items');
    }
};
