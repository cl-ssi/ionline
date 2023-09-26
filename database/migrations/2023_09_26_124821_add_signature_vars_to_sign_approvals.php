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
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->string('filename')->after('digital_signature')->nullable();
            $table->integer('startY')->after('digital_signature')->nullable();
            $table->string('position')->after('digital_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('startY');
            $table->dropColumn('filename');
        });
    }
};
