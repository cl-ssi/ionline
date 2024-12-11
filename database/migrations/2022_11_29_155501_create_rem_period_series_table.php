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
        Schema::create('rem_period_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')
                ->constrained('rem_periods');
            $table->foreignId('serie_id')
                ->constrained('rem_series');
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
        Schema::dropIfExists('rem_period_series');
    }
};
