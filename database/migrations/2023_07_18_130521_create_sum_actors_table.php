<?php

use Database\Seeders\SumActorSeeder;
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
        Schema::create('sum_actors', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        app(SumActorSeeder::class)->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sum_actors');
    }
};
