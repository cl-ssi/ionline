<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeApprovedAtToArqRequestForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            Schema::table('arq_request_forms', function (Blueprint $table) {
                $table->dropColumn('approved_at');
            });
            Schema::table('arq_request_forms', function (Blueprint $table) {
                $table->timestamp('approved_at')->after('old_signatures_file_id')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
