<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('rut')->unique();
            $table->string('address')->nullable();
            $table->string('commune')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact')->nullable();

            $table->unsignedBigInteger('pharmacy_id')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pharmacy_id')->references('id')->on('frm_pharmacies');
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
}
