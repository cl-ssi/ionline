<?php

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
        Schema::table('psi_requests', function (Blueprint $table) {
            $table->enum('status_inhability', ['none', 'in_progress', 'enabled', 'disabled'])->nullable()->after('disability');
            $table->date('signed_at')->nullable()->after('status_inhability');
            $table->date('test_send_at')->nullable()->after('signed_at');
            $table->date('approved_at')->nullable()->after('test_send_at');
            $table->date('rejected_at')->nullable()->after('approved_at');
            $table->date('certificated_at')->nullable()->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */


     public function down(): void
     {
         Schema::table('psi_requests', function (Blueprint $table) {
             $table->dropColumn([
                 'status_inhability',
                 'signed_at',
                 'test_send_at',
                 'approved_at',
                 'rejected_at',
                 'certificated_at'
             ]);
         });
     }
};
