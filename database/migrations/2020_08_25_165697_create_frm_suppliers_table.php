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
        Schema::create('frm_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rut'); //->unique();
            $table->string('address')->nullable();
            $table->string('commune')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact')->nullable();
            $table->foreignId('pharmacy_id')->constrained('frm_pharmacies')->default(1);
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
        Schema::dropIfExists('frm_suppliers');
    }
};
