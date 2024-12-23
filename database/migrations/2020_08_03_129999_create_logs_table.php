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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->longText('message');
            $table->string('module')->nullable();
            $table->foreignId('module_id')->nullable()->constrained('cfg_modules');
            $table->string('uri')->nullable();
            $table->longText('formatted');
            $table->longText('context');
            $table->string('level')->index();
            $table->string('level_name');
            $table->string('channel')->index();
            $table->longText('extra');
            // Additional custom fields I added
            $table->string('remote_addr')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('record_datetime');
            $table->dateTime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
