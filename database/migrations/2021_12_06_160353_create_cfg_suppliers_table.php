<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfgSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cfg_suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('run')->unique();
            $table->char('dv', 1);
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('telephone')->nullable();

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
        Schema::dropIfExists('cfg_suppliers');
    }
}
