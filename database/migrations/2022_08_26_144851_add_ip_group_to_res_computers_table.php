<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpGroupToResComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('res_computers', function (Blueprint $table) {
            $table->string('ip_group')->after('mac_address')->nullable();
            $table->string('rack')->after('ip_group')->nullable();
            $table->string('vlan')->after('rack')->nullable();
            $table->string('network_segment')->after('vlan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('res_computers', function (Blueprint $table) {
            $table->dropColumn(['ip_group']);
            $table->dropColumn(['rack']);
            $table->dropColumn(['vlan']);
            $table->dropColumn(['network_segment']);
        });
    }
}
