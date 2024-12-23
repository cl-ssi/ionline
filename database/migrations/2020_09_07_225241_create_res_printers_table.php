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
        Schema::create('res_printers', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->enum('type', ['printer', 'scanner', 'plotter']);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->macAddress('mac_address')->unique()->nullable(); //new
            $table->enum('active_type', ['leased', 'own', 'user']); //new
            $table->string('comment')->nullable();
            $table->enum('status', ['active', 'inactive']); //new
            $table->foreignId('place_id')->nullable()->constrained('cfg_places')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('res_printer_user', function (Blueprint $table) {
            $table->foreignId('printer_id')->constrained('res_printers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
};
