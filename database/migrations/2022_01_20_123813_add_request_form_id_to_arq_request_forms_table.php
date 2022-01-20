<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestFormIdToArqRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->foreignId('request_form_id')->nullable()->after('id')->constrained('arq_request_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->dropForeign(['request_form_id']);
            $table->dropColumn('request_form_id');
        });
    }
}
