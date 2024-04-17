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
        Schema::table('tng_trainings', function (Blueprint $table) {
            $table->string('municipal_profile')->after('feedback_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tng_trainings', function (Blueprint $table) {
            $table->dropColumn('municipal_profile');
        });
    }
};
