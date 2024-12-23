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
        Schema::create('pro_programming_item_pro_hour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programming_item_id')->constrained('pro_programming_items');
            $table->foreignId('professional_hour_id')->constrained('pro_professional_hours');
            $table->decimal('activity_performance', 7, 1)->nullable();
            $table->decimal('designated_hours_weeks', 7, 1)->nullable();
            $table->double('hours_required_year', 8, 2)->nullable();
            $table->double('hours_required_day', 8, 2)->nullable();
            $table->double('direct_work_year', 15, 8)->nullable(); // Jornadas Directas Año
            $table->double('direct_work_hour', 15, 8)->nullable(); // Jornadas Horas Directas Diarias double('column', 15, 8)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_programming_item_pro_hour');
    }
};
