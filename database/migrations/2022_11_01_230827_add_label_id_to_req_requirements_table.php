<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabelIdToReqRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_requirements', function (Blueprint $table) {
            $table->foreignId('label_id')->nullable()->after('to_authority')->constrained('req_labels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_requirements', function (Blueprint $table) {
            $table->dropForeign(['label_id']);
            $table->dropColumn('label_id');
        });
    }
}
