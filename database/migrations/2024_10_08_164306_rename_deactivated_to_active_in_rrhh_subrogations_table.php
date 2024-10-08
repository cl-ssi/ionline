<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDeactivatedToActiveInRrhhSubrogationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_subrogations', function (Blueprint $table) {
            $table->renameColumn('deactivated', 'active')->default(true);
        });

        DB::table('rrhh_subrogations')->update([
            'active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_subrogations', function (Blueprint $table) {
            $table->renameColumn('active', 'deactivated')->default(false);
        });
    }
}
