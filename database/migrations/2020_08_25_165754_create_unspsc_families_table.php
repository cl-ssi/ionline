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
        Schema::create('unspsc_families', function (Blueprint $table) {
            $table->id();

            $table->integer('code')->nullable();
            $table->string('name')->nullable();
            $table->timestamp('experies_at')->nullable();
            $table->foreignId('segment_id')->nullable()->constrained('unspsc_segments');

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
        Schema::dropIfExists('unspsc_families');
    }
};
