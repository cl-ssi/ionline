<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrgDestructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drg_destructions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reception_id');
            $table->string('police');
            $table->date('destructed_at');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('lawyer_id')->unsigned();
            $table->bigInteger('observer_id')->nullable()->unsigned();
            $table->bigInteger('lawyer_observer_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reception_id')->references('id')->on('drg_receptions');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manager_id')->references('id')->on('users');
            $table->foreign('lawyer_id')->references('id')->on('users');
            $table->foreign('observer_id')->references('id')->on('users');
            $table->foreign('lawyer_observer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drg_destructions');
    }
}
