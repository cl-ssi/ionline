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
        Schema::create('cl_communes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commune_id')->nullable()->constrained('cl_communes');
            $table->string('name')->nullable();
            $table->string('code_deis')->nullable();
            $table->foreignId('region_id')->constrained('cl_regions');

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
};
