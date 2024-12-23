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
        Schema::create('rrhh_authorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->date('date')->nullable();
            $table->string('position');
            $table->enum('type', ['manager', 'delegate', 'secretary'])->default('manager');
            $table->string('decree')->nullable();
            $table->date('from_time');
            $table->date('to_time')->nullable();
            $table->foreignId('representation_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->unique(['date', 'organizational_unit_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_authorities');
    }
};
