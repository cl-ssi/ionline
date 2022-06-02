<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToCfgSuppliers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_suppliers', function (Blueprint $table) {
            $table->string('code', 255)->after('dv')->nullable();
            $table->string('commercial_activity', 255)->after('name')->nullable();
            $table->string('branch_code', 255)->after('name')->nullable();
            $table->string('branch_name', 255)->after('branch_code')->nullable();

            $table->string('contact_name', 255)->after('branch_name')->nullable();
            $table->string('contact_phone', 255)->after('contact_name')->nullable();
            $table->string('contact_email', 255)->after('contact_phone')->nullable();
            $table->string('contact_charge', 255)->after('contact_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_suppliers', function (Blueprint $table) {
            //
        });
    }
}
