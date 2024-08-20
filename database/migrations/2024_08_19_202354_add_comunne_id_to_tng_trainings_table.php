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
            $table->string('activity_in')->after('other_activity_type')->nullable();
            $table->foreignId('commune_id')->after('activity_in')->nullable()->constrained('cl_communes');
            $table->boolean('allowance')->after('commune_id')->nullable();
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
            $table->dropColumn('activity_in');
            $table->dropForeign(['commune_id']);
            $table->dropColumn('allowance');
        });
    }
};
