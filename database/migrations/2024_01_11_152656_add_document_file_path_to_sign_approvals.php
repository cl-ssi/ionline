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
            $table->string('document_pdf_path')->nullable()->after('document_route_params');
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
            $table->dropColumn('document_pdf_path');
        });
    }
};
