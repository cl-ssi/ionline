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
        Schema::table('fin_reception_items', function (Blueprint $table) {
            $table->double('Cantidad')->change(); //cantidad
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fin_reception_items', function (Blueprint $table) {
            $table->integer('Cantidad')->change(); //cantidad
        });
    }
};
