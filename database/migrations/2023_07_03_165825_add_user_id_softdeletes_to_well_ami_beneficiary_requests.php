<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdSoftdeletesToWellAmiBeneficiaryRequests extends Migration
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
            $table->foreignId('user_id')->after('rut_funcionario')->nullable()->constrained('users');
            $table->string('historial')->after('establecimiento')->nullable();
            $table->softDeletes()->after('updated_at');
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
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('historial');
            $table->dropColumn('deleted_at');
        });
    }
}
