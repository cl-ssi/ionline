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
        Schema::create('rrhh_monthly_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->text('records');
            $table->date('report_date');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'date'], 'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_monthly_attendances');
    }
};
