<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('dispatch_id')->unsigned();

            $table->foreign('dispatch_id')->references('id')->on('frm_dispatches')->onDelete('cascade');
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
        Schema::dropIfExists('frm_files');
    }
}
