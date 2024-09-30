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
        Schema::table('arq_passengers', function (Blueprint $table) {
            $table->string('document_type')->after('passenger_type')->nullable();
            $table->string('document_number')->after('document_type')->nullable();
            $table->string('run')->nullable()->change();
            $table->char('dv',1)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arq_passengers', function (Blueprint $table) {
            $table->dropColumn('document_type');
            $table->dropColumn('document_number');
        });
    }
};
