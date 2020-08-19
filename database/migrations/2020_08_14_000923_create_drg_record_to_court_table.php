<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrgRecordToCourtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drg_record_to_court', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->nullable();
            $table->date('document_date')->nullable();
            $table->text('observation')->nullable();
            $table->unsignedInteger('reception_id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('lawyer_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reception_id')->references('id')->on('drg_receptions');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manager_id')->references('id')->on('users');
            $table->foreign('lawyer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drg_record_to_court');
    }
}
