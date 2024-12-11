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
        Schema::table('rem_files', function (Blueprint $table) {
            $table->foreignId('rem_period_series_id')->nullable()->after('locked')->constrained('rem_period_series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rem_files', function (Blueprint $table) {
            $table->dropForeign('rem_files_rem_period_series_id_foreign');
        });
    }
};
