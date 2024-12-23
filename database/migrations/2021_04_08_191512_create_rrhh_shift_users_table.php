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
        Schema::create('rrhh_shift_users', function (Blueprint $table) {
            $table->id();
            $table->date('date_from');
            $table->date('date_up');
            $table->foreignId('asigned_by')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shift_types_id')->constrained('rrhh_shift_types');
            $table->foreignId('organizational_units_id')->constrained('organizational_units');
            $table->string('groupname')->nullable();
            $table->text('commentary')->nullable();
            $table->integer('position')->nullable();
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
        Schema::dropIfExists('rrhh_shift_users');
    }
};
