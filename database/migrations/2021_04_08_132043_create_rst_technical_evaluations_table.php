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
        Schema::create('rst_technical_evaluations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_end')->nullable();
            $table->enum('technical_evaluation_status', ['pending', 'complete', 'rejected']);
            $table->string('reason')->nullable();
            $table->text('observation')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('request_replacement_staff_id')->constrained('rst_request_replacement_staff');

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
        Schema::dropIfExists('rst_technical_evaluations');
    }
};
