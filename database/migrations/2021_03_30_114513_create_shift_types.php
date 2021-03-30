<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shortname');
            $table->string('day_series')->comment('they can be D:day;N:night;L:long;F:free;7 spaces separated by comma ');
            $table->boolean('status')->default(TRUE);
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
        Schema::dropIfExists('shift_types');
    }
}
