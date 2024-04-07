<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->nullable();
            $table->string('id_minsal')->nullable();
            $table->string('name')->nullable();

            /* @mirandaljorge para que es esta relacion? */
            $table->foreign('region_id')->references('id')->on('cl_regions');

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
        Schema::dropIfExists('cl_regions');
    }
}
