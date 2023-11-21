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
        Schema::create('rrhh_compensatory_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->datetime('request_date')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('hrs')->nullable();
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
        Schema::dropIfExists('rrhh_compensatory_days');
    }
};
