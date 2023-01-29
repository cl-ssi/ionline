<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhNewAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_new_authorities', function (Blueprint $table) {
            //
            $table->id();
            $table->date('from');
            $table->time('from_time');
            $table->date('to');
            $table->date('to_time');
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
        Schema::table('rrhh_new_authorities', function (Blueprint $table) {
            //
        });
    }
}
