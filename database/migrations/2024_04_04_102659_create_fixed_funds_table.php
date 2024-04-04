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
        Schema::create('fin_fixed_funds', function (Blueprint $table) {
            $table->id();
            $table->string('concept');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('organizational_unit_id')->constrained('organizational_units')->cascadeOnDelete();
            $table->date('period');
            $table->string('res_number')->nullable();
            $table->unsignedInteger('total');
            $table->date('delivery_date')->nullable();
            $table->date('rendition_date')->nullable();
            //[0 = 'Creado', 1 = 'Entregado', 2 = 'Rendido', 3 = 'Aprobado', 4 = 'Rechazado']
            $table->unsignedSmallInteger('status')->default(0);
            $table->text('observations')->nullable();
            $table->unsignedInteger('rendition_amount')->nullable();
            $table->unsignedInteger('refund_amount')->nullable();
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
        Schema::dropIfExists('fin_fixed_funds');
    }
};
