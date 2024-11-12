<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE sign_approvals MODIFY COLUMN reject_observation varchar(255) AFTER approver_id");
        DB::statement("ALTER TABLE sign_approvals MODIFY COLUMN status TINYINT(1) AFTER approver_at");

        DB::statement("ALTER TABLE sign_approvals MODIFY COLUMN approvable_id BIGINT(20) AFTER filename");
        DB::statement("ALTER TABLE sign_approvals MODIFY COLUMN approvable_type varchar(255) AFTER filename");

        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->renameColumn('reject_observation', 'approver_observation');

            $table->foreignId('sent_to_user_id')->after('document_route_params')->nullable()->constrained('users');
            $table->foreignId('sent_to_ou_id')->after('document_route_params')->nullable()->constrained('organizational_units');

        });

        DB::table('sign_approvals')->update([
            'sent_to_ou_id' => DB::raw('approver_ou_id'),
            'sent_to_user_id' => DB::raw('approver_id'),
        ]);

        //DB::statement("ALTER TABLE sign_approvals MODIFY COLUMN approver_ou_id BIGINT(20) AFTER approver_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('sign_approvals')->update([
            'approver_ou_id' => DB::raw('sent_to_ou_id'),
        ]);
        
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->dropForeign(['sent_to_user_id']);
            $table->dropColumn('sent_to_user_id');

            $table->dropForeign(['sent_to_ou_id']);
            $table->dropColumn('sent_to_ou_id');

            $table->renameColumn('approver_observation','reject_observation');
        });

        DB::statement("ALTER TABLE sign_approvals MODIFY COLUMN reject_observation varchar(255) AFTER status");
    }
};
