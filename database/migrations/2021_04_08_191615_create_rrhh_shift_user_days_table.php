<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhShiftUserDaysTable extends Migration
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
            
            $table->unsignedBigInteger('shift_user_id');


            $table->foreign('shift_user_id')->references('id')->on('rrhh_shift_users');
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
}
