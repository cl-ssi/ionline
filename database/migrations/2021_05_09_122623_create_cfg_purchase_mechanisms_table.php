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
        Schema::create('cfg_purchase_mechanisms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cfg_purchase_mechanism_type', function (Blueprint $table) {
            $table->foreignId('purchase_mechanism_id')->constrained('cfg_purchase_mechanisms')->onDelete('cascade');
            $table->foreignId('purchase_type_id')->constrained('cfg_purchase_types')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_purchase_mechanism_type');
        Schema::dropIfExists('cfg_purchase_mechanisms');
    }
};
