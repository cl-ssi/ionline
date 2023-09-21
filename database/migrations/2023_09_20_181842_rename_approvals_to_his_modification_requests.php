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
        Schema::table('his_modification_requests', function (Blueprint $table) {
            $table->renameColumn('approvals', 'observation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('his_modification_requests', function (Blueprint $table) {
            $table->renameColumn('observation', 'approvals');
        });
    }
};
