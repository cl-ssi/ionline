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
        Schema::create('sum_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->string('status')->nullable();
            $table->integer('resolution_number')->nullable();
            $table->date('resolution_date')->nullable();
            $table->foreignId('type_id')->default(1)->constrained('sum_types');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('observation')->nullable();
            $table->foreignId('investigator_id')->nullable()->constrained('users');
            $table->foreignId('actuary_id')->nullable()->constrained('users');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
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
        Schema::dropIfExists('sum_summaries');
    }
};
