<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToWellAmiBeneficiaryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('well_ami_beneficiary_requests', function (Blueprint $table) {
            //
            $table->string('estado')->after('establecimiento')->nullable();
            $table->foreignId('ami_manager_id')->after('estado')->nullable()->constrained('users');
            $table->datetime('ami_manager_at')->after('ami_manager_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('well_ami_beneficiary_requests', function (Blueprint $table) {
            //
            $table->dropForeign(['ami_manager_id']);
            $table->dropColumn('ami_manager_id');
            $table->dropColumn('ami_manager_at');
            $table->dropColumn('estado');
        });
    }
}
