<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEnumVisatorTypeToSignaturesFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures_flows', function (Blueprint $table) {
            DB::statement("ALTER TABLE doc_signatures_flows MODIFY COLUMN visator_type ENUM('elaborador', 'revisador', 'aprobador')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signatures_flows', function (Blueprint $table) {
            DB::statement("ALTER TABLE doc_signatures_flows MODIFY COLUMN visator_type ENUM('elaborador', 'revisador')");
        });
    }
}
