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
        Schema::create('drg_countersample_destructions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number')->nullable();
            $table->date('destructed_at');
            $table->foreignId('court_id')->nullable()->constrained('drg_courts');
            $table->string('police');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignId('lawyer_id')->constrained('users');
            $table->foreignId('observer_id')->constrained('users');
            $table->foreignId('lawyer_observer_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        // add to drg_reception_items foreign key
        Schema::table('drg_reception_items', function (Blueprint $table) {
            $table->foreignId('countersample_destruction_id')->after('destruct')->nullable()->constrained('drg_countersample_destructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop from drg_reception_items foreign key
        Schema::table('drg_reception_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('countersample_destruction_id');
        });

        Schema::dropIfExists('drg_countersample_destructions');
    }
};
