<?php

use App\Models\Documents\Approval;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->string('initials', 6)->after('sent_to_user_id')->nullable();
        });

        // Obtener las iniciales para cada sent_to_ou_id y sent_to_user_id
        $ouInitials = [];
        $userInitials = [];

        Approval::with(['sentToOu', 'sentToUser'])->chunk(100, function ($approvals) use (&$ouInitials, &$userInitials) {
            foreach ($approvals as $approval) {
                if ($approval->sentToOu && !isset($ouInitials[$approval->sent_to_ou_id])) {
                    $ouInitials[$approval->sent_to_ou_id] = substr($approval->sentToOu->initials, 0, 6);
                }
                if ($approval->sentToUser && !isset($userInitials[$approval->sent_to_user_id])) {
                    $userInitials[$approval->sent_to_user_id] = substr($approval->sentToUser->initials, 0, 6);
                }
            }
        });

        // Actualizar en masa las iniciales para cada sent_to_ou_id
        foreach ($ouInitials as $ouId => $initials) {
            DB::table('sign_approvals')
                ->where('sent_to_ou_id', $ouId)
                ->update(['initials' => $initials]);
        }

        // Actualizar en masa las iniciales para cada sent_to_user_id
        foreach ($userInitials as $userId => $initials) {
            DB::table('sign_approvals')
                ->where('sent_to_user_id', $userId)
                ->update(['initials' => $initials]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->dropColumn('initials');
        });
    }
};
