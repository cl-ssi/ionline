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
        Schema::create('rrhh_performance_report_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->nullable();
            $table->string('name')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->year('year')->nullable();
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
        Schema::dropIfExists('rrhh_performance_report_periods');
    }
};
