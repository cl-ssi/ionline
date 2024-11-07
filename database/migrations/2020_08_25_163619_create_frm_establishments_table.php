<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('email')->nullable();
            //se añade por defecto 1 para la relación con la bodega
            $table->foreignId('pharmacy_id')->nullable()->constrained('frm_pharmacies');
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
        Schema::dropIfExists('frm_establishments');
    }
}
