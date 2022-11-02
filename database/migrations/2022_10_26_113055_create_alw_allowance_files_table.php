<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlwAllowanceFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alw_allowance_files', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('file');

            $table->foreignId('allowance_id');
            $table->foreignId('user_id');

            $table->foreign('allowance_id')->references('id')->on('alw_allowances');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('alw_allowance_files');
    }
}
