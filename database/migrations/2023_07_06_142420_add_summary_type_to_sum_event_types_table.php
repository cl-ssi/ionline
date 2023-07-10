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
        Schema::table('sum_event_types', function (Blueprint $table) {
            $table->foreignId('summary_type_id')->default(1)->after('num_repeat')->constrained('sum_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_event_types', function (Blueprint $table) {
            $table->dropForeign(['summary_type_id']);
            $table->dropColumn('summary_type_id');
        });
    }
};
