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
        Schema::create('ppl_purchase_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_creator_id')->nullable()->constrained('users');
            $table->foreignId('user_responsible_id')->nullable()->constrained('users');
            $table->string('description')->nullable();
            $table->string('purpose')->nullable();
            $table->string('position')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->string('organizational_unit')->nullable();
            $table->foreignId('subdirectorate_id')->nullable()->constrained('organizational_units');
            $table->string('subdirectorate')->nullable();
            $table->string('subject')->nullable();
            $table->foreignId('program_id')->nullable()->constrained('cfg_programs');
            $table->string('program')->nullable();
            $table->float('estimated_expense', 15, 2)->nullable();
            $table->float('approved_estimated_expense', 15, 2)->nullable();
            $table->string('period')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('assign_user_id')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppl_purchase_plans');
    }
};
