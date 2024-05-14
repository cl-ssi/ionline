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
        Schema::create('fin_cdps', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');
            $table->string('file_path')->nullable();
            $table->foreignId('request_form_id')->constrained('arq_request_forms');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('establishment_id')->constrained('establishments');
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
        Schema::dropIfExists('fin_cdps');
    }
};
