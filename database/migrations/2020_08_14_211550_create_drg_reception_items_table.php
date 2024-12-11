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
        Schema::create('drg_reception_items', function (Blueprint $table) {
            $table->id('id');
            $table->text('description');
            $table->foreignId('substance_id')->constrained('drg_substances');
            $table->string('nue')->nullable();
            $table->integer('sample_number');
            $table->decimal('document_weight', 10, 3)->nullable();
            $table->decimal('gross_weight', 10, 3);
            $table->decimal('net_weight', 10, 3)->nullable();
            $table->decimal('estimated_net_weight', 10, 3)->nullable();
            $table->decimal('sample', 8, 3);
            $table->decimal('countersample', 8, 3);
            $table->decimal('destruct', 10, 3);
            $table->string('equivalent')->nullable();
            $table->foreignId('reception_id')->constrained('drg_receptions');
            $table->integer('result_number')->nullable();
            $table->date('result_date')->nullable();
            $table->foreignId('result_substance_id')->nullable()->constrained('drg_substances');
            $table->boolean('dispose_precursor')->nullable();
            $table->integer('countersample_number');
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
        Schema::dropIfExists('drg_reception_items');
    }
};
