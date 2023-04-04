<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorrelativeToPartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->unsignedInteger('correlative')->default(0)->after('id');
        });

        DB::statement('UPDATE partes SET correlative = id');

        DB::statement("UPDATE doc_correlatives SET correlative = (SELECT MAX(id) FROM partes) + 1 WHERE establishment_id = 38 AND type_id is NULL;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->dropColumn('correlative');
        });
    }
}
