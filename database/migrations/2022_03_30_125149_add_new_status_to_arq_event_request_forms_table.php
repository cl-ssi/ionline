<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNewStatusToArqEventRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE arq_event_request_forms MODIFY status ENUM('approved', 'rejected', 'pending', 'does_not_apply') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE arq_event_request_forms MODIFY status ENUM('approved', 'rejected', 'pending') NOT NULL");
    }
}
