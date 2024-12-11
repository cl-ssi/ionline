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
        Schema::create('mammography_days', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->unsignedInteger('exam_available')->default(0);
            $table->unsignedInteger('exam_used')->default(0);

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
        Schema::dropIfExists('mammography_days');
    }
};
