<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubt31ToDocServiceRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            //
            $table->string('subt31', 2000)->after('resolve')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_service_requests', function (Blueprint $table) {
            //
            $table->dropColumn('subt31');
        });
    }
}
