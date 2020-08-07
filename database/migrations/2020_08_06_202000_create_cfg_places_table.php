<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfgPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('cfg_places', function (Blueprint $table) {
              $table->id();
              $table->string('name');
              $table->string('description')->nullable()->default(NULL);
              $table->foreignId('location_id')->unsigned();
              $table->timestamps();
              $table->softDeletes();

              $table->foreign('location_id')
                    ->references('id')->on('cfg_locations')
                    ->onDelete('restrict');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_places');
    }
}
