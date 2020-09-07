<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResPrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('res_printers', function (Blueprint $table) {
          $table->id();
          $table->string('serial')->nullable();
          $table->enum('type',['printer','scanner','plotter']);
          $table->string('brand')->nullable();
          $table->string('model')->nullable();
          $table->ipAddress('ip')->nullable();
          $table->macAddress('mac_address')->unique()->nullable(); //new
          $table->enum('active_type',['leased','own','user']); //new
          $table->string('comment')->nullable();
          $table->enum('status',['active','inactive']); //new
          $table->foreignId('place_id')->nullable();
          $table->timestamps();
          $table->softDeletes();
          $table->foreign('place_id')->references('id')->on('cfg_places')->onDelete('restrict');
      });

      Schema::create('res_printer_user', function (Blueprint $table) {
          $table->foreignId('printer_id')->unsigned();
          $table->foreign('printer_id')->references('id')->on('res_printers')->onDelete('cascade');
          $table->foreignId('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('res_printers');
        Schema::dropIfExists('res_printer_user');
    }
}
