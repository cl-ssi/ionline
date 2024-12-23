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
        Schema::create('rrhh_shift_user_days', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->string('commentary');
            $table->integer('status')->comment('they can be 1:assigned;2:completed,3:extra shift,4:shift change5: medical license,6: union jurisdiction,7: legal holiday,8: exceptional permit or did not belong to the service.');

            $table->foreignId('shift_user_id')->constrained('rrhh_shift_users');
            $table->foreignId('shift_close_id')->nullable()->constrained('rrhh_shift_close');
            $table->string('working_day');
            $table->integer('derived_from')->nullable();

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
        Schema::dropIfExists('rrhh_shift_user_days');
    }
};
