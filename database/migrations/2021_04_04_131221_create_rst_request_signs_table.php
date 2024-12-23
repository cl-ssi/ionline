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
        Schema::create('rst_request_signs', function (Blueprint $table) {
            $table->id();
            //Firmas en filas
            $table->integer('position');
            $table->string('ou_alias');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('request_status');
            $table->longText('observation')->nullable();
            $table->dateTime('date_sign')->nullable();
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
        Schema::dropIfExists('rst_request_signs');
    }
};
