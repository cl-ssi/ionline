<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWreControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wre_controls', function (Blueprint $table) {
            $table->id();

            $table->boolean('type'); // 1:ingreso 0:egreso
            $table->date('date')->nullable();
            $table->text('note')->nullable();

            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('origin_id')->nullable()->constrained('wre_origins');
            $table->foreignId('destination_id')->nullable()->constrained('wre_destinations');

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
        Schema::dropIfExists('wre_controls');
    }
}
