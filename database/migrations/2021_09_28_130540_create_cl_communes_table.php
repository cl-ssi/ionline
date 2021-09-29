<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_communes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commune_id')->nullable();
            $table->string('name')->nullable();
            $table->string('code_deis')->nullable();
            $table->foreignId('region_id');

            $table->foreign('region_id')->references('id')->on('cl_regions');
            $table->foreign('commune_id')->references('id')->on('cl_communes');

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
        Schema::dropIfExists('cl_communes');
    }
}
