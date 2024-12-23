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
        Schema::create('drg_act_precursors', function (Blueprint $table) {
            $table->id();

            $table->datetime('date')->nullable();
            $table->string('full_name_receiving')->nullable();
            $table->string('run_receiving')->nullable();
            $table->text('note')->nullable();

            $table->foreignId('delivery_id')->nullable()->constrained('users');

            $table->softDeletes();
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
        Schema::dropIfExists('drg_act_precursors');
    }
};
