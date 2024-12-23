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
        Schema::create('rrhh_new_authorities', function (Blueprint $table) {
            //
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->date('date')->nullable();
            $table->string('position')->nullable();
            $table->string('type')->nullable();
            $table->string('decree')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->foreignId('representation_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('rrhh_new_authorities');
    }
};
