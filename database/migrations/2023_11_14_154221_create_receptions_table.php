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
        Schema::create('fin_receptions', function (Blueprint $table) {
            $table->id();
            $table->string('number'); // Correlatives
            $table->date('date');
            $table->foreignId('reception_type_id')->constrained('fin_reception_types');

            $table->string('purchase_order')->nullable();
            $table->text('header_observation')->nullable();

            $table->boolean('partial_reception')->nullable(); // Si se selecciono completa o parcial
            $table->boolean('order_completed')->nullable(); // Marcar orden completada

            $table->boolean('cenabast')->nullable();

            $table->string('doc_type')->nullable();
            $table->string('doc_number')->nullable();
            $table->string('doc_date')->nullable();
            $table->unsignedInteger('total')->nullable();
            
            $table->text('footer_observation')->nullable();
            
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('creator_ou_id')->constrained('organizational_units');

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
        Schema::dropIfExists('fin_receptions');
    }
};
