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
        Schema::create('alw_destinations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commune_id')->nullable()->constrained('cl_communes');
            $table->foreignId('locality_id')->nullable()->constrained('cl_localities');
            $table->string('description')->nullable();
            $table->foreignId('allowance_id')->nullable()->constrained('alw_allowances');

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
        Schema::dropIfExists('alw_destinations');
    }
};
