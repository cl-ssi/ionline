<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->boolean('rejected')->after('devuelto')->nullable();
            $table->text('reason_rejection')->nullable()->after('rejected');
            $table->foreignId('rejected_user_id')->nullable()->after('reason_rejection')->constrained('users');
            $table->datetime('rejected_at')->after('rejected_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->dropColumn('rejected');
            $table->dropColumn('reason_rejection');
            $table->dropForeign(['rejected_user_id']);
            $table->dropColumn('rejected_user_id');
            $table->dropColumn('rejected_at');
        });
    }
};
