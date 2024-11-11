<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgrSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_signers', function (Blueprint $table) {
            $table->id();
            $table->string('appellative'); // APELATIVO DIRECTOR, DIRECTOR (S)
            $table->string('decree'); // DECRETO DIRECTOR
            $table->unsignedBigInteger('user_id'); // DIRECTOR USER ID
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('agr_signers');
    }
}
