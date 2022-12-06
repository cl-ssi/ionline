<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('res_mobiles', function (Blueprint $table) {
          $table->id();
          $table->string('brand');
          $table->string('model');
          $table->integer('number')->unique();
          $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('res_mobiles');
    }
}
