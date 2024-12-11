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
        Schema::create('cl_regions', function (Blueprint $table) {
            $table->id();
            /* @mirandaljorge para que es esta relacion? */
            $table->foreignId('region_id')->nullable()->constrained('cl_regions');
            $table->string('id_minsal')->nullable();
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
        Schema::dropIfExists('cl_regions');
    }
};
