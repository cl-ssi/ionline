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
        Schema::create('cfg_suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('run')->unique();
            $table->char('dv', 1);
            $table->string('code', 255)->nullable();
            $table->string('name');
            $table->string('branch_code', 255)->nullable();
            $table->string('branch_name', 255)->nullable();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_phone', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_charge', 255)->nullable();
            $table->string('commercial_activity', 255)->nullable();
            $table->string('address')->nullable();
            $table->foreignId('region_id')->nullable()->constrained('cl_regions');
            $table->foreignId('commune_id')->nullable()->constrained('cl_communes');
            $table->string('telephone')->nullable();

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
        Schema::dropIfExists('cfg_suppliers');
    }
};
