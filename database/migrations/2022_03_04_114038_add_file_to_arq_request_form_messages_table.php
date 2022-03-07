<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileToArqRequestFormMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_request_form_messages', function (Blueprint $table) {
            $table->string('file')->nullable()->after('message');
            $table->string('file_name')->nullable()->after('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_request_form_messages', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropColumn('file_name');
        });
    }
}
